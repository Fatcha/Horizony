<?php

namespace App\Models\Fatcha\SW;
class Quest_Pnj{
	function QuestPnj($id_pnj=0){
		$this->pnj_id=$id_pnj;
	}

	//Affichage des données
	function getValue($colum_name){
		$reqColum=mysql_query("select $colum_name as myValue from  sw_quest_new_pnj where id_pnj=".$this->pnj_id." limit 1") or die ("getValue pnj ".mysql_error());
		$myValue=mysql_fetch_object($reqColum);

		return $myValue->myValue;
	}

	function setValue($colum_name,$value){

		$reqColum=mysql_query("update sw_quest_new_pnj set $colum_name='$value'  where id_pnj=".$this->pnj_id." limit 1") or die ("setValue pnj ".mysql_error());

	}

	public function getAllAvailablePnj(){
		$arrayToReturn=array();
		$reqAllPnj=mysql_query("select id_pnj from sw_quest_new_pnj where 	pnj_zone=0");
		while($reqPnj=mysql_fetch_object($reqAllPnj)){
			array_push($arrayToReturn,$reqPnj->id_pnj);
		}
		return $arrayToReturn;
	}
	public function getUrlAvatar(){


			$anim=new Avatar($this->getValue("pnj_avatar_id"));

			return "/game_elements/avatars/".$anim->getValue("animation_name");
	}
	 public function talkToPnj()   {
						$myPerso=new Perso($_SESSION["member_id"]);
						if($myPerso->getValue("perso_zone") != $this->getValue("pnj_zone")){
								return "";
						}


						$_SESSION["totalGet"] = "<br />"; // variable de session qui contient ce que le perso gagne/cr�e pour affichage
						$_SESSION["choix"] = "<br />"; // variable de session qui contient ce que le choix oui ou non
						$_SESSION["seeAll"]=true;
						if(!$_SESSION["seeAll"]){
							 $whereClose="AND (t1.time_visible='".$_SESSION["periode"]."' OR t1.time_visible='everytime')";
						 }else{
							 $whereClose="";
						 }

						$reqpnj=mysql_query("select * from sw_quest_new_pnj as t1 ,  sw_quest_new_etapes as t2,  sw_quest_new_etapes_pnj as t3 where t1.id_pnj=".$this->pnj_id." AND t1.id_pnj=t3.id_pnj AND t3.id_etape=t2.id_etape  $whereClose") or die(mysql_error());//AND t1.posmap=".$_SESSION["myPerso"]->posmap."
						$pnj=mysql_fetch_object($reqpnj)	;

						//if(!empty($pnj->id_pnj) && canSeeIt("pnj",$pnj->id_pnj)){

									//$img=showPic("pnjG",$pnj->id_pnj,$pnj->img);
									$mytext="";// "<span ><strong>$pnj->name</strong></span><br>";
									//"<span ><img src='$img'><br><br>";
									$reqTesting=mysql_query("select * from sw_quest_new_testing  where ref_testing=0  and id_etape=$pnj->id_etape");

									$testing=mysql_fetch_object($reqTesting);
									$quest=new Quest($testing->id_quest);

									$textPnj=$quest->parseEtape($testing->id_test,$pnj->id_etape);

									$textPnj=str_replace(chr(13),"",$textPnj);
									$textPnj=str_replace(chr(12),"",$textPnj);
									$textPnj=nl2br($textPnj);
									if(strlen($textPnj)>0){
										$mytext.="<b>".$this->getValue("pnj_name")."</b>:<br/>".$textPnj;
									}



									//$mytext=parseContent($mytext);
									//pseudo
									//$mytext=str_replace("[pseudo]",$_SESSION["myPerso"]->login,$mytext);
									//race
									//$mytext=str_replace("[race]",showRace($_SESSION["myPerso"]->race),$mytext);
									//classe
									//$mytext=str_replace("[classe]",showClass($_SESSION["myPerso"]->class_perso),$mytext);
									//sexe
									//$mytext=str_replace("[sexe]",$_SESSION["myPerso"]->sexe,$mytext);

									//if($_SESSION["choix"]!="<br />"){
										//print $_SESSION["choix"];
										//$_SESSION["choix"]="";
									//}

						/*}else{
							 $mytext="<center>il n'y a rien ici...</center>";
						}*/
						return $mytext;

			}

}
?>
