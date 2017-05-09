<?php

namespace App\Models\Fatcha\SW;
use App\Models\Character;
use App\Models\MonsterInstance;
use App\Models\Boost;

/**
 * attackManager class (hold attack static functions
 *
 * @package    lozone
 * @subpackage none
 * @author     Laurent De Meyere
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class AttackManager {
    
    

    /*  Calcul Between Agility*/
    public static function calculAlgility($attackerAglity,$defenderAgility){
        $proba= (($attackerAglity/$defenderAgility)*1)/2;
		if($proba>1) { $proba=1; }
		else if($proba<0) { $proba=0; }
        return $proba;
    }
    /*  Calcul Between Inteligence*/
    public static function calculIntel($attackerIntel,$defenderIntel){
        $proba= (($attackerIntel/$defenderIntel)*1)/2;
		if($proba>1) { $proba=1; }
		else if($proba<0) { $proba=0; }
        return $proba;
    }
   
    /*  Calcul Between Agility on CAC*/
    public static function calculHitOnElement($attacker_value_attack,$boost_cothes,$boost_potions,$proba,$rage,$other_life){
        
        $hit_value=round((($attacker_value_attack+$boost_cothes)*$rage)*(rand(0,($proba*100))/100));
		$hit_value+=$boost_potions;
		if($hit_value<0) { $hit_value=0; }
		else if($hit_value>$other_life) { $hit_value=$other_life; }
        return $hit_value;
    }
    /*  Calcul pourcent of hit removed*/
    public static function calculPourcent($hit_value,$other_life_left){
        if($other_life_left>0) { 
            $pourcentRemoved=$hit_value/$other_life_left; 
        }else { 
            $pourcentRemoved=1; 
        }
        if($pourcentRemoved>1) { $pourcentRemoved=1; }
        return $pourcentRemoved;
    }
    
    
    public static function doCACPlayerVsMonsterAttack(SwPerso $attacker,  SwMonstermap $defender) {
        $out=array();
        $monster_type=  SwTypemonster::getMonsterTypeWidthId($defender->getIdMonster());
        //Get Boost from clothes
        $boostAttackerClothes=$attacker->getBoostClothes();
        //1.Calcul agility
       
        $agility=self::calculAlgility($attacker->getAgilite()+$boostAttackerClothes["agilite"],$monster_type->getAgilite());
       
        //2.Calcul Hit on monster. $rage is set to 1
        // TODO: add boost potion
        $boostForce = SwBoost::getActiveCaractBoost($attacker, "force");
        $out["hit_value"]=self::calculHitOnElement($attacker->getPuissance(),$boostAttackerClothes["force"],$boostForce["valeur"],  $agility, 1, $defender->getLifeleft());
        //3.calcul pourcent 0to 1
        $out["hit_pourcent"]=self::calculPourcent($out["hit_value"], $defender->getLifeleft());
        
        return $out;
    }
    /*
     * Attack from monster to player
     */
    public static function doCACMonsterVsCharacterAttack(Character $characterInstance,  $monster_map_instance_id) {
        $out=array();
        
        $monsterMapInstance = MonsterInstance::find($monster_map_instance_id);
        $monster_type =  $monsterMapInstance->monster;
        //Get Boost from clothes
        $boostDefenderClothes = $characterInstance->getBoostClothes();
        //1.Calcul agility
        $agility = self::calculAlgility($monster_type->agilite,$characterInstance->agilite + $boostDefenderClothes["agilite"]);
        
        //2.Calcul Hit on monster. $rage is set to 1
        // TODO: add boost potion
        $boostForce = Boost::getActiveCaractBoost($characterInstance->user, "force");
        //$out["hit_value"]=self::calculHitOnElement($characterInstance->getPuissance(),$boostDefenderClothes["force"],$boostForce["valeur"],  $agility, 1, $monsterMapInstance->getLifeleft());
         //calculHitOnElement($attacker_value_attack,$boost_cothes,$boost_potions,$proba,$rage,$other_life)s
        $out["hit_value"]=self::calculHitOnElement($monster_type->puissance, 0 , 0,  $agility, 1, $characterInstance->life);
        //3.calcul pourcent 0 to 1
        $out["hit_pourcent"]=self::calculPourcent($out["hit_value"], $monsterMapInstance->lifeleft);
        
        return $out;
    }
    
    public static function doAttack($actionType, $actionId,   $attacker,  $defender) {
        $out['success'] = true;
        $out['message'] = "";

        $attackCost = config('app_site_config_attackCost'); // cost of an attack (fightturn)
        $minDefendLevel = config('app_site_config_min_defend_level'); // minimum defender level to allow attack
        $minAttackLevel = config('app_site_config_min_attack_level'); // minimum attacker level to allow attack
        $isAgressive = 1; // flag to tell if action is agressive or not (soin magic not agressive)
        // if magic, get magic info (and check if magic is agressive)
        if ($actionType == "magic") {
            $magicData = SwTypemagie::returnTypemagie($actionId);
            // if magic do not exist
            if (empty($magicData)) {
                $out['success'] = false;
                $out['message'] = "magic do not exist";
                return $out;
            } elseif ($magicData->getTypesort() == "soin") {
                $isAgressive = 0;
            }
        }
        

        // global checks (common for all attack)
        // if defender not found (not exist)
        if (empty($defender)) {
            $out['success'] = false;
            $out['message'] = "no defender";
            // if attacker not found (not exist)
        } elseif (empty($attacker)) {
            $out['success'] = false;
            $out['message'] = "no attacker";
            // if action on self, no agressive allowed
        } elseif ($isAgressive && $attacker->getIdOwner() == $defender->getIdOwner()) {
            $out['success'] = false;
            $out['message'] = "you can't attack yourself";
            // is defender alive
        } elseif (!$defender->isAlive()) {
            $out['success'] = false;
            $out['message'] = "defender not alive";
            // is attacker alive
        } elseif (!$attacker->isAlive()) {
            $out['success'] = false;
            $out['message'] = "attacker not alive";
            // is defender on same posmap then attacker
        } elseif ($defender->getPosmap() != $attacker->getPosmap()) {
            $out['success'] = false;
            $out['message'] = "not same pos";
            // not enough action point
        } elseif ($attacker->getFightturn() < $attackCost) {
            $out['success'] = false;
            $out['message'] = "not enough action points";
        }

        // if check fail return
        if (!$out['success']) {
            return $out;
        }


        // player vs player checks
        if ($defender->getMyType() == "perso" && $attacker->getMyType() == "perso") {
            // defender has min level to be attacked
            if ($isAgressive && $defender->getLevel() <= $minDefendLevel) {
                $out['success'] = false;
                $out['message'] = "defender min level not reached";
                // attacker has min level to attacked
            } elseif ($isAgressive && $attacker->getLevel() <= $minAttackLevel) {
                $out['success'] = false;
                $out['message'] = "attacker min level not reached";
                // attacker is sleeping
            } elseif ($attacker->getEtat() == "sleeping") {
                $out['success'] = false;
                $out['message'] = "attacker sleeps";
                // defender is sleeping
            } elseif ($defender->getEtat() == "sleeping") {
                $out['success'] = false;
                $out['message'] = "defender sleeps";
                // defender is in forteresse
            } elseif ($defender->getEtat() == "forteresse") {
                $out['success'] = false;
                $out['message'] = "defender in fort";
                // check if defender in same clan
            } elseif ($attacker->getIdClan() > 0 && $attacker->getIdClan() == $defender->getIdClan()) {
                $out['success'] = false;
                $out['message'] = "defender in same clan";
                // check if user already reach attack limit on defender (default 3)
            } elseif ($isAgressive) {
                $theDay = date("Y-m-d");
                $req = mysql_query("select count(id_attack) as nbr from sw_attack where id_attaquant=" . $attacker->getIdOwner() . " and id_defender=" . $defender->getIdOwner() . " and day='" . $theDay . "' AND type_attack='attack'");
                $compteur = mysql_fetch_object($req);
                $theLimit = config('app_site_config_attack_limit');
                if ($compteur->nbr >= $theLimit) {
                    $out['success'] = false;
                    $out['message'] = "attack limit reached";
                }
            }
        }

        // if check fail return
        if (!$out['success']) {
            return $out;
        }

        if ($actionType == "magic") {
            $outAttack = self::doMagicAttack($magicData, $attacker, $defender);
        } elseif ($actionType == "cac") {
            $outAttack = self::doCacAttack($actionId, $attacker, $defender);
        }



        $out['success'] = true;
        $out['attack_datas'] = $outAttack;
        $out['actionType'] = $actionType;
        $out['actionId'] = $actionId;
        return $out;
    }

    public static function doMagicAttack(SwTypemagie $magicData,  $attacker, $defender) {
        $out['success'] = true;
        $out['message'] = "";

        // if not enough mana
        if ($attacker->getMana() < $magicData->getMana()) {
            $out['success'] = false;
            $out['message'] = "Not enough mana";
            // if enough intel
        } elseif ($attacker->getIntel() < $magicData->getIntel()) {
            $out['success'] = false;
            $out['message'] = "Not enough intel";
            // if enough level
        } elseif ($attacker->getLevel() < $magicData->getLevel()) {
            $out['success'] = false;
            $out['message'] = "Not enough level";
            // check if user has magic
        } elseif (!SwPouvoirmagic::hasMagic($attacker, $magicData->getIdType())) {
            $out['success'] = false;
            $out['message'] = "Do not have magic";
        }
        // if check fail return
        if (!$out['success']) {
            return $out;
        }

        // if defender is player
        if ($defender->getMyType() == "perso") {
            // add clothe carac
            $defenderClotheBoost = $defender->getBoostClothes();
            $defenderIntel = $defender->getIntel() + $defenderClotheBoost['intel'];

            $attackerClotheBoost = $attacker->getBoostClothes();
            $attackerPotionBoostIntel = SwBoost::getActiveCaractBoost($attacker, "intel");
            $attackerIntel = $attacker->getIntel() + $attackerClotheBoost['intel'];

            //calcul des dégats
            $proba =self::calculIntel($attackerIntel, $defenderIntel) ;
            //$myPoints = round($magicData->getValeur() * (rand(0, ($proba*100)) / 100));
            $datasMagicPvP=self::calculHitOnElement($magicData->getValeur() ,$attackerClotheBoost["intel"],$attackerPotionBoostIntel["valeur"],$proba,1,$defender->getLife());
            //Sort throwed  get datas
            $player_life_remaining=$defender->removeLife($datasPvM["hit_value"]);
            $gold_dropped_by_player=  $defender->removeGoldWithPourcent($datasPvM["hit_pourcent"]);
            
            //Add Gold and XP to attacker
            Swperso::addMoney($attacker_id, $gold_dropped_by_player);
           
            //monster is killed
            if($player_life_remaining==0){
               $attacker-> addPlayerKill();
            }
            // remove mana
            $attacker->setMana($attacker->getMana() - $magicData->getMana());
            //if defender is monster
        } else if($defender->getMyType() == "monster") {
            $monsterType=  SwTypemonster::getMonsterTypeWidthId($defender->getidMonster());
            //getBoost Attacker
            $attackerClotheBoost = $attacker->getBoostClothes();
            $attackerPotionBoostIntel = SwBoost::getActiveCaractBoost($attacker, "intel");
            $attackerIntel = $attacker->getIntel() + $attackerClotheBoost['intel'];
            $proba =self::calculIntel($attackerIntel, $monsterType->getIntel()) ;
            $datasMagicPvP=self::calculHitOnElement($magicData->getValeur() ,$attackerClotheBoost["intel"],$attackerPotionBoostIntel["valeur"],$proba,1,$defender->getLifeleft());
            //Sort throwed  get datas
            $monster_life_remaining=$defender->addDommage($datasPvM["hit_value"]);
            $gold_dropped_by_monster=  $defender->removeGoldWithPourcent($datasPvM["hit_pourcent"]);
            
            //Add Gold and XP to attacker
            Swperso::addMoney($attacker_id, $gold_dropped_by_monster);
           
            //monster is killed
            if($monster_life_remaining==0){
               $attacker->addMonsterKill();
            }
            // remove mana
            $attacker->setMana($attacker->getMana() - $magicData->getMana());
        }

        return $out;
    }

    public static function doCacAttack($actionId, $attacker, $defender) {
        //self::doCacPlayerVsMonster($actionType, $actionId, SwPerso  $attacker, SwMonstermap $defender) 
        $out=array();
        if($attacker->getMyType()=="perso" && $defender->getMyType()=="monster"){
            $monsterType=  SwTypemonster::getMonsterTypeWidthId($defender->getIdMonster());
            
            $attacker_id=$attacker->getIdOwner();
            $datasPvM=self::doCACPlayerVsMonsterAttack($attacker, $defender);
            $monster_life_remaining=$defender->addDommage($datasPvM["hit_value"]);
            $gold_dropped_by_monster=$defender->removeGoldWithPourcent($datasPvM["hit_pourcent"]);
            $xp_dropped_by_monster=$defender->removeXPWithPourcent($datasPvM["hit_pourcent"]);
            //Add Gold and XP to attacker
            Swperso::addMoney($attacker_id, $gold_dropped_by_monster);
            $attacker->giveXp( $xp_dropped_by_monster);
            //monster is killed
            if($monster_life_remaining==0){
               $attacker-> addMonsterKill();
            }
            $out["life_remaining"]=$monster_life_remaining;
            $out["gold_won"]=$xp_dropped_by_monster;
            $out["xp_won"]=$xp_dropped_by_monster;
            $out["damage_done"]=$datasPvM["hit_value"];
            $out["damage_pourcent"]=$datasPvM["hit_pourcent"];
            $out["total_life_pourcent"]=$defender->getPourcentLifeRemaining();
        }
        
        return $out;
    }

    public static function setDamage($damage, $attacker,  SwPerso $defender, SwPerso $affect) {
        switch ($affect) {
            case "life":
                $defenderPoints = $defender->getLife();
                //pourcentage de vie retiree
                $pourcentPoints = $damage / $defenderPoints;
                if ($pourcentPoints >= 1) {
                    $pourcentPoints = 1;
                }
                $defenderPoints = $defenderPoints - $damage;

                //if defender die, lose clothe or object
                if ($defenderPoints <= 0) {
                    $defenderPoints = 0;
                    $defenderXP*=0.99;
                    $defender->setXp($defenderXP);
                    $defender->setDead($defender->getDead()+1);

                    // add kill stats to attacker
                    $attacker->setKillplayer($attacker->getKillplayer() + 1);
                    $attacker->setmalus($attacker->getmalus() + 1);

                    // lose Clothe
                    $defender->loseClothe();
                    // lose Item
                    $defender->loseItem();
                    // give ration de voyage to killed defender
                    $defender->giveItem(9);
                }

                // remove life from defender
                $defender->setLife($defenderPoints);

                //retrieve stolen gold from defender
                $defenderGold = $defender->getGold();
                $goldStolen = round($defenderGold * $pourcentPoints);
                $defender->setGold($defenderGold - $goldStolen);
                // share gold with clan if has clan, if not get all gold)
                $attacker->shareGold($goldStolen);

                // check difference of level with defender
                $diflvl=$attacker->getLevel()-$defender->getLevel();
                if($diflvl <= 0) { $tempxp = $damage; }
                else { $tempxp = ceil($damage / $diflvl); }
                // give xp to attacker
                $attacker->giveXp($tempxp);

                break;
            case "mana":
                $defenderPoints = $defender->getMana();
                break;
            case "gold":
                $defenderPoints = $defender->getGold();
                break;
            case "fightturn":
                $defenderPoints = $defender->getFightTurn();
                break;
        }

        // remove action points (fightturn)
        $attackerFightturn = $attacker->getFightturn() - config('app_site_config_attackCost');
        if ($attackerFightturn < 0) {
            $attackerFightturn = 0;
        }
        $attacker->setFightturn($attackerFightturn);
    }

}