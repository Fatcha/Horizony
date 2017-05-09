<?php

namespace App\Models\Fatcha\SW;
class Quest{
	function Quest($quest_id=0){
		$this->quest_id=$quest_id;
	}

	//Affichage des données
	/*function getValue($colum_name){
		$reqColum=mysql_query("select $colum_name as myValue from  sw_quest_new_pnj where id_pnj=".$this->pnj_id." limit 1") or die ("getValue pnj ".mysql_error());
		$myValue=mysql_fetch_object($reqColum);

		return $myValue->myValue;
	}

	function setValue($colum_name,$value){

		$reqColum=mysql_query("update sw_quest_new_pnj set $colum_name='$value'  where id_pnj=".$this->pnj_id." limit 1") or die ("setValue pnj ".mysql_error());

	}*/

		//////////////////////////////////////////////////////////////////////////////
		// 		    Cette fonction met l'avancement de la quete a jour			   //
		//////////////////////////////////////////////////////////////////////////////
		function setAvancement($id_quest,$num_etape,$id_testing,$which_text){

			$reqAvancement=mysql_query("select id_avancement from sw_quest_new_avancement where id_owner=".$_SESSION["member_id"]." AND id_quest=$id_quest AND num_etape=$num_etape order by num_etape");
			$avancement=mysql_fetch_object($reqAvancement);
			if(empty($avancement)){
				mysql_query("insert into sw_quest_new_avancement (id_quest,num_etape,id_owner,id_testing,which_text) values ($id_quest,$num_etape,".$_SESSION["member_id"].",$id_testing,'$which_text')") or die(mysql_error());
			}
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// 		    on va parser l'étape les test sont effectu� par checking qui retourne true ou false a parseTesting			   //
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function parseEtape($id_test,$id_etape){

			$reqTesting=mysql_query("select * from sw_quest_new_testing where id_test=$id_test and id_etape=$id_etape limit 1");
			$testing=mysql_fetch_object($reqTesting);

			if($this->parseTesting($testing->id_test,$testing->id_quest)){
				$this->parseGetting($testing->id_test,$testing->id_quest,'true');
				if(!empty($testing->testing_true)){
					$_SESSION["choix"]="";
					$text=$this->parseEtape($testing->testing_true,$id_etape);
				}else{
					if(!empty($testing->num_etape_true)){
						$this->setAvancement($testing->id_quest,$testing->num_etape_true,$testing->id_test,'true');
					}
					return $testing->text_true;
				}
			}else{
				$this->parseGetting($testing->id_test,$testing->id_quest,'false');
				if(!empty($testing->testing_false)){
					$_SESSION["choix"]="";
					$text=$this->parseEtape($testing->testing_false,$id_etape);
				}else{
					if(!empty($testing->num_etape_false)){
						$this->setAvancement($testing->id_quest,$testing->num_etape_false,$testing->id_test,'false');
					}
					return $testing->text_false;
				}
			}
			return $text;
		}
		  /////////////////////////////////////////////////////////////////////////////////////////
		 // 		    on boucle sur les check a faire sur un test 									 //
		////////////////////////////////////////////////////////////////////////////////////////
		function parseTesting($id_test,$id_quest){

			$reqCheck=mysql_query("select * from sw_quest_new_check where id_test=$id_test ") or die(mysql_error());
			while($check=mysql_fetch_object($reqCheck)){
				$testCheck=$this->checking($check->id_check,$id_quest);
				if(!$testCheck){
					return false;
				}
			};
			return true;
		}
		  /////////////////////////////////////////////////////////////////////////////////////////
		 // 		    on boucle sur les get a faire sur un test 								 //
		////////////////////////////////////////////////////////////////////////////////////////
		function parseGetting($id_test,$id_quest,$typetest){

			$reqGetting=mysql_query("select * from sw_quest_new_get  where id_test=$id_test and typetest='$typetest' ") or die(mysql_error());
			while($getting=mysql_fetch_object($reqGetting)){
				$this->getting($getting->id_get,$id_quest);
			};
		}
		  /////////////////////////////////////////////////////////////////////////////////////////
		 // 		    				ici se font les tests un par un									 //
		////////////////////////////////////////////////////////////////////////////////////////
		function checking($id_check,$id_quest){
			$myPerso=new Perso($_SESSION["member_id"]);

			$reqCheck=mysql_query("select * from sw_quest_new_check  where id_check=$id_check limit 1");
			$check=mysql_fetch_object($reqCheck);
			if($check->checking=="level"){
		// LEVEL
				$tempText="if(".$myPerso->getValue("perso_level")."$check->signe $check->valeur){
					return true;
				}else{
					return false;
				}";
				return eval($tempText);
		// OR
			}else if($check->checking=="or"){
				$tempText="if(".$myPerso->getValue("perso_money")."$check->signe $check->valeur){
					return true;
				}else{
					return false;
				}";
				return eval($tempText);
		// PUISSANCE (force)
			}else if($check->checking=="puissance"){
				$tempText="if(".$myPerso->getValue("perso_point_combat")."$check->signe $check->valeur){
					return true;
				}else{
					return false;
				}";
				return eval($tempText);
		// CONSTITUTION
			}else if($check->checking=="constitution"){
				$tempText="if(".$myPerso->getValue("perso_point_constitution")."$check->signe $check->valeur){
					return true;
				}else{
					return false;
				}";
				return eval($tempText);

		// INTELLIGENCE
			}else if($check->checking=="intel"){
				$tempText="if(".$myPerso->getValue("perso_point_concentration")."$check->signe $check->valeur){
					return true;
				}else{
					return false;
				}";
				return eval($tempText);
		// MANA
			}else if($check->checking=="mana"){
				$tempText="if(".$myPerso->getValue("perso_mana")."$check->signe $check->valeur){
					return true;
				}else{
					return false;
				}";
				return eval($tempText);
		// VIE
			}else if($check->checking=="vie"){
				$tempText="if(".$myPerso->getValue("perso_life")."$check->signe $check->valeur){
					return true;
				}else{
					return false;
				}";
				return eval($tempText);
		// POINTS ACTION
			}else if($check->checking=="point_action"){
				$tempText="if(".$myPerso->getValue("perso_pa")."$check->signe $check->valeur){
					return true;
				}else{
					return false;
				}";
				return eval($tempText);
		// KILLMONSTER
			}else if($check->checking=="kill_monster"){
				$tempText="if(".$myPerso->getValue("perso_kill_monsters")."$check->signe $check->valeur){
					return true;
				}else{
					return false;
				}";
				return eval($tempText);
		// KILLPLAYER
			}else if($check->checking=="kill_player"){
				$tempText="if(".$myPerso->getValue("perso_kill_players")."$check->signe $check->valeur){
					return true;
				}else{
					return false;
				}";
				return eval($tempText);
		// QUEST ETAPE
			}else if($check->checking=="quest_etape") {
				$reqVarTest=mysql_query("select num_etape from sw_quest_new_avancement where id_owner=".$_SESSION["member_id"]." and id_quest=$id_quest order by num_etape desc limit 1") or die (mysql_error());
				$varTest=mysql_fetch_object($reqVarTest);

				if(empty($varTest->num_etape)){
					$var1="0";
				}else{
					$var1=$varTest->num_etape;
				}
					$tempText="if($var1 $check->signe $check->valeur){
							return true;
						}else{
							return false;
						}";


					return eval($tempText);
				/*}else{
					return false;
				}*/

		// Sexe
			}else if($check->checking=="sexe"){
				if($valeur==1){
					$valeur="m";
				}else{
					$valeur="f";
				}
				if($myPerso->getValue("perso_sex") == $valeur){
					return true;
				}else{
					return false;
				}
		// OBJET
			}else if($check->checking=="objet"){

				if($check->signe =="=="){
					if($myPerso->haveThisItem($check->valeur)){
							return true;
					}

					return false;
				}else if($check->signe =="!="){
					if($myPerso->haveThisItem($check->valeur)){
							return false;
					}

					return true;
				}

		// MAGIE
			}else if($check->checking=="magie"){
					if($myPerso->haveThisMagic($check->valeur)){
						return true;
					}

				return false;
		// VETEMENT
			}else if($check->checking=="vetement"){
				if($myPerso->haveThisClothe($check->valeur)){
						return true;
				}

				return false;
		// VETEMENT PORTE
			}else if($check->checking=="porte"){
				if($myPerso->haveThisClotheWeared($check->valeur)){
						return true;
				}

				return false;


		// FLAG MONSTRE
			}else if($check->checking=="flag_monster"){

				if($myPerso->haveKilledMonster($check->valeur)){
						return true;
				}

				return false;
		// Random

			}else if($check->checking=="random"){
				$pourcent=rand(1,100);
				$tempText="if($pourcent <= $check->valeur){
					return true;
				}else{
					return false;
				}";
				return eval($tempText);

		// reponse en oui ou non
			}else if($check->checking=="monchoix"){
				//si le choix==0 on peut dire que c'est vide
				if($check->valeur==0){
					if(!isset($_POST["choix"])){
						$_SESSION["choix"].="<table><tr><td><form name='formoui' action='?id_pnj=".$_GET["id_pnj"]."' method='post'><input type='hidden' name='choix' value='1'><input type='submit' value='Oui' class='input2'></form></td><td><form name='formnon' action='?id_pnj=".$_GET["id_pnj"]."' method='post'><input type='hidden' name='choix' value='2'><input type='submit' value='Non' class='input2'></form></td></tr></table>";
						return true;
					}else{
						return false;
					}
					//sinon on va chercher ce que c'est
				}else{
					if($_POST["choix"]==1){
						//�tant la premiere r�ponse
						return true;
					}else if($_POST["choix"]==2){
						//ici la seconde

						return false;
					}
				}
		//  est e que l'inventaire est plein
			}else if($check->checking=="inventory_full"){
				return $myPerso->isInventoryFull();
                // Titre honorifique
			}else if($check->checking=="honorific"){
				if($myPerso->haveThisHonorific($check->valeur)){
						return true;
				}
				return false;
		// QUEST fin de qu�te
			}else if($check->checking=="quest"){
				$reqAvancement=mysql_query("select t1.num_etape,t2.endquest from sw_quest_new_avancement as t1 join sw_quest_new_description as t2 where t1.id_owner=".$_SESSION["member_id"]." and t1.id_quest=$check->valeur and t2.id_quest=$check->valeur order by t1.num_etape desc limit 1") or die (mysql_error());
				$varAvanc=mysql_fetch_object($reqAvancement);
				if(empty($varAvanc->num_etape)){
					$avancement=0;
				}else{
					$avancement=$varAvanc->num_etape;
				}

				if($avancement >= $varAvanc->endquest && $avancement!=0){
					return true;
				}else{
					return false;
				}
			}
		}


		  /////////////////////////////////////////////////////////////////////////////////////////
		 // 		    				ici se font les gets un par un							 //
		///////////////////////////////////////////////////////////////////////////////////////////
		function getting($id_get,$id_quest){
			$myPerso=new Perso($_SESSION["member_id"]);

			$reqGetting=mysql_query("select getting,valeur,nombre,signe,typetest from sw_quest_new_get where id_get=$id_get limit 1");
			$getting=mysql_fetch_object($reqGetting);
		// XP
			if($getting->getting=="xp"){
				if ($getting->signe == "="){
					$myPerso->setValue("perso_xp",$getting->valeur);
				}else if ($getting->signe == "+"){
					$myPerso->giveXp($getting->valeur);
				}else if ($getting->signe == "-"){
					$myPerso->removeXP($getting->valeur);
				}
				// XP
			}else if($getting->getting=="point_action"){
				 if ($getting->signe == "-"){
					$myPerso->getPA($getting->valeur);
				}
		// LEVEL
			}else if($getting->getting=="level"){
				if ($getting->signe == "+"){
					for($i=1;$i<=$getting->valeur;$i++){
					$myPerso->levelup();
					}
				}

		// OBJET
			}else if($getting->getting=="objet"){
				if ($getting->signe == "+"){
					$myPerso->giveItem($getting->valeur);
				}else if ($getting->signe == "-"){
					$myPerso->removeItem($getting->valeur);
				}
		// MAGIE
			}else if($getting->getting=="magie"){
				if ($getting->signe == "+"){
					$myPerso->giveMagic($getting->valeur);
				}else if ($getting->signe == "-"){

				}
		// OR
			}else if($getting->getting=="or"){
				if ($getting->signe == "="){
					//mysql_query("update sub_perso set gold=$getting->valeur where id_owner=".$_SESSION["member_id"]." limit 1");
					//$_SESSION["totalGet"].="- Vous avez maintenant $getting->valeur Gopi(s) en poche<br />";
				}else if ($getting->signe == "+"){
					$myPerso->giveMoney($getting->valeur);

					//mysql_query("update sub_perso set gold=gold+$getting->valeur where id_owner=".$_SESSION["member_id"]." limit 1");
					//$_SESSION["totalGet"].="- Vous gagnez $getting->valeur Gopi(s)<br />";
				}else if ($getting->signe == "-"){
					$myPerso->getMoney($getting->valeur);
				}
		// VETEMENT
			}else if($getting->getting=="vetement"){
				if ($getting->signe == "+"){
					$myPerso->giveClothe($getting->valeur);
				}else if ($getting->signe == "-"){
					$myPerso->removeClothe($getting->valeur);
				}
		// ARME
			}else if($getting->getting=="arme"){
				if ($getting->signe == "+"){
					$myPerso->giveWeapon($getting->valeur);
				}else if ($getting->signe == "-"){
					$myPerso->removeWeapon($getting->valeur);
				}

		// MANA
			}else if($getting->getting=="mana"){
				if ($getting->signe == "="){
				}else if ($getting->signe == "+"){
					$myPerso->addMana($getting->valeur);
				}else if ($getting->signe == "-"){
				}
		// LIFE
			}else if($getting->getting=="vie"){
				if ($getting->signe == "="){
				}else if ($getting->signe == "+"){
					$myPerso->addLife($getting->valeur);
				}else if ($getting->signe == "-"){
					$myPerso->removeLife($getting->valeur);
				}

		// POSITION - sur la map
			}else if($getting->getting=="position_map"){
					$arrayPosition=split(";",$getting->valeur);
					//perso_posx 	perso_posy
					$myPerso->setValue("perso_zone",$arrayPosition[0]);
					$myPerso->setValue("perso_posx",$arrayPosition[1]);
					$myPerso->setValue("perso_posy",$arrayPosition[2]);


		// Respawn - lieu de reapparition
			}else if($getting->getting=="respawn"){
				if ($getting->signe == "="){
					mysql_query("update sub_perso set respawn=$getting->valeur where id_owner=".$_SESSION["member_id"]." limit 1");
				}else if($getting->signe == "+"){
					mysql_query("update sub_perso set respawn=".($_SESSION["myPerso"]->posmap+$getting->valeur)." where id_owner=".$_SESSION["member_id"]." limit 1");
				}else if($getting->signe == "-"){
					mysql_query("update sub_perso set respawn=".($_SESSION["myPerso"]->posmap-$getting->valeur)." where id_owner=".$_SESSION["member_id"]." limit 1");
				}


		// FUNC_FULLVIEMANA
			}else if($getting->getting=="func_fullviemana"){
					$myPerso->fullLifeMana();
                // TITRE HONORIFIQUE
			}else if($getting->getting=="honorific"){
				if ($getting->signe == "+"){
					$myPerso->giveHonorific($getting->valeur);
				}else if ($getting->signe == "-"){
					$myPerso->removeHonorific($getting->valeur);
				}
		// FUNC_KILLVIRTUAL
			}else if($getting->getting=="func_killvirtual"){
					killVirtual($_SESSION["member_id"]);
					$_SESSION["totalGet"].="- Vous venez de mourir et �tes rapparti� � votre temple<br />";

		// FUNC_REMOVEQUEST (avancement)
			}else if($getting->getting=="func_removeQuest"){
				$this->removeQuest() ;
		// Go to respawn point
			}else if($getting->getting=="go_respawn"){
				mysql_query("update sub_perso set posmap=respawn where id_owner=".$_SESSION["member_id"]." limit 1");
				$_SESSION["totalGet"].="- Vous �tes ramen� � votre point de r�surection<br />";
			}
		}

		 public function removeQuest() {

			mysql_query("delete from sw_quest_new_avancement where id_owner=".$_SESSION["member_id"]." AND id_quest=".$this->quest_id);

			return true;
		 }





}
?>
