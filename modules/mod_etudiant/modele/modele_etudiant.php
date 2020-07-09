 
<?php
require_once 'modules/mod_generique/modele_generique.php';
class ModeleEtudiant extends ModeleGenerique{
 
    public function __construct () {// le constructeur ne se déclenche pas à l'ouverture de la page
    
        parent::__construct();
    }
 
    public function student_existBD($nomEtud,$prenomEtud){
        $req = self::$bdd->prepare('SELECT nomEtud,prenomEtud from etudiant where nomEtud = ? and prenomEtud = ?');
        $req->execute(array($nomEtud,$prenomEtud));
 
        return $donnees = $req->fetch();
    }
 
    public function studentModif_existBD($nomEtud,$prenomEtud,$numeroINE){
        $req = self::$bdd->prepare('SELECT nomEtud,prenomEtud from etudiant where nomEtud = ? and prenomEtud = ? and numeroINE != ?');
        $req->execute(array($nomEtud,$prenomEtud,$numeroINE));
 
        return $donnees = $req->fetch();
    }
 
    public function add_studentBD($numApo,$numINE,$photoEtud,$nomEtud,$prenom,$dateNaiss,
    $courriel,$tel,$adrr1,$adrr2,$AnneePromo,$situationActu){
 
        if(empty($numApo)) $numApo=0; // obligatoire si on veut mettre à null
        if(empty($numINE)) $numINE=0;
        if(empty($tel)) $tel=0;
        if(empty($dateNaiss)) $dateNaiss='0000-00-00';
 
        $req = self::$bdd->prepare('INSERT into etudiant (numApogee,numeroINE,
        photoEtud,nomEtud,prenomEtud,dateNaiss,courriel,telEtud,adr1,adr2,
        anneePromotion,situationActuelle) values (?,?,?,?,?,?,?,?,?,?,?,?)');
        $req->execute(array($numApo,$numINE,$photoEtud,$nomEtud,$prenom,$dateNaiss,
    $courriel,$tel,$adrr1,$adrr2,$AnneePromo,$situationActu));
 
        return self::$bdd->lastInsertId();
    }
 
   public function add_studentBD_sans_img($numApo,$numINE,$nomEtud,$prenom,$dateNaiss,
    $courriel,$tel,$adrr1,$adrr2,$AnneePromo,$situationActu){
      $req = self::$bdd->prepare('INSERT into etudiant (numApogee,numeroINE
            nomEtud,prenomEtud,dateNaiss,courriel,telEtud,adr1,adr2,
            anneePromotion,situationActuelle) values (?,?,?,?,?,?,?,?,?,?,?)');
            $req->execute(array($numApo,$numINE,$nomEtud,$prenom,$dateNaiss,
        $courriel,$tel,$adrr1,$adrr2,$AnneePromo,$situationActu));
           
    }
    public function est_present($numEtud){
           $req = self::$bdd->prepare('SELECT numApogee FROM etudiant where numApogee=?');
           $req->execute(array($numEtud));
           return !empty($req->fetchAll());
    }

  
    public function get_Students($page, $idGroupe){
        if ($idGroupe == 0)
            $reponse = self::$bdd->query('SELECT * FROM etudiant order by numeroINE desc limit '.(($page-1)*5). ','. 5);
        else{
            $reponse = self::$bdd->query('SELECT * FROM etudiant inner join apparteniraugroupe using(numeroINE) where idGroupe='.$idGroupe);
        }
 
        return $reponse;
        $reponse->closeCursor();
    }

    function trie_INE($page,$numINE){
        $sql = 'SELECT * from etudiant where numeroINE = :ine order by numeroINE desc limit '.(($page-1)*5). ','. 5;
        $req = self::$bdd -> prepare($sql);
        $req -> bindParam(':ine', $numINE);
        $req -> execute();
        $tab = $req -> fetchAll();
        return $tab;
    }

    function nb_trie_INE($numINE){
        $sql = 'SELECT * from etudiant where numeroINE like :ine';
        $req = self::$bdd -> prepare($sql);
        $req -> bindParam(':ine', $numINE);
        $req -> execute();
        $nbEtud = $req -> rowCount();
        return $nbEtud;
    }

    function trie_apogee($page,$numApogee){
        $sql = 'SELECT * from etudiant where numApogee = :apog order by numeroINE desc limit '.(($page-1)*5). ','. 5;
        $req = self::$bdd -> prepare($sql);
        $req -> bindParam(':apog', $numApogee);
        $req -> execute();
        $tab = $req -> fetchAll();
        return $tab;
    }

    function nb_trie_apogee($numApog){
        $sql = 'SELECT * from etudiant where numApogee like :apog';
        $req = self::$bdd -> prepare($sql);
        $req -> bindParam(':apog', $numApog);
        $req -> execute();
        $nbEtud = $req -> rowCount();
        return $nbEtud;
    }
    
    function nb_trie_etablissement($nomEtab){
        $sql = 'SELECT * from etudiant inner join former using(numeroINE) inner join etablissement using (idEtablissement) where nomEtablissement like :nomEtab';
        $req = self::$bdd -> prepare($sql);
        $req -> bindParam(':nomEtab', $ecoleEntreprise);
        $req -> execute();
        $nbEtud = $req -> rowCount();
        return $nbEtud;
    }

    function trie_etablissement($page,$nomEtab){
        $sql = 'SELECT * from etudiant inner join former using(numeroINE) inner join etablissement using (idEtablissement) where nomEtablissement like :nomEtab order by numeroINE desc limit '.(($page-1)*5). ','. 5;
        $req = self::$bdd -> prepare($sql);
        $req -> bindParam(':nomEtab', $nomEtab);
        $req -> execute();
        $tab = $req -> fetchAll();
        return $tab;
    }

    public function nb_students(){
        $reponse = self::$bdd->query('SELECT numeroINE from etudiant');
        $nbEtud = $reponse->rowCount();
        return $nbEtud;
    }
 
    public function get_studentBD($numeroINE){
        $req = self::$bdd->prepare('SELECT * FROM etudiant WHERE numeroINE = ?');
        $req->execute(array($numeroINE));
        return $req->fetch();
 
    }
 
    public function update_studentBD($numApo,$numINE,$photoEtud,$nomEtud,$prenom,$dateNaiss,
    $courriel,$tel,$adrr1,$adrr2,$AnneePromo,$situationActu){
        
        if(empty($numApo)) $numApo=0; // obligatoire si on veut mettre à null
        if(empty($numINE)) $numINE=0;
        if(empty($tel)) $tel=0;
        if(empty($dateNaiss)) $dateNaiss='0000-00-00';
 
        $req = self::$bdd->prepare('UPDATE etudiant SET numApogee = (?) , numeroINE = (?) , photoEtud = (?) , nomEtud = (?) ,
         prenomEtud = (?) , dateNaiss = (?) , courriel = (?) , telEtud = (?) , adr1 = (?) , adr2 = (?) , 
        anneePromotion = (?) , situationActuelle = (?) where numeroINE = (?)');
        $req->execute(array($numApo,$numINE,$photoEtud,$nomEtud,$prenom,$dateNaiss,
    $courriel,$tel,$adrr1,$adrr2,$AnneePromo,$situationActu,$numINE));
 
    }
    
    public function delete_studentBD($numeroINE,$id){
        if($id==0){
            $req = self::$bdd->prepare('DELETE FROM former where numeroINE = ?');
            $req->execute(array($numeroINE));

            $req2 = self::$bdd->prepare('DELETE FROM apparteniraugroupe where numeroINE = ?');
            $req2->execute(array($numeroINE));
 
            $req2 = self::$bdd->prepare('DELETE FROM etudiant where numeroINE = ?');
            $req2->execute(array($numeroINE));
        }else{
            $req2 = self::$bdd->prepare('DELETE FROM apparteniraugroupe where numeroINE = ? and idGroupe = ?');
            $req2->execute(array($numeroINE,$id));
        }
 
    }
 
    public function creer_groupe($nom){
        $req = self::$bdd->prepare('INSERT INTO groupe(nomGroupe) values (?)');
        $req->execute(array($nom));
    }
 
    public function get_groupes(){
        $req = self::$bdd->query('SELECT * FROM groupe');
        return $req;
    }
 
    public function groupe_exists($nom){
        $req = self::$bdd->prepare('SELECT idGroupe FROM groupe where nomGroupe=?');
        $req->execute(array($nom));
        $donnees = $req->rowCount();
        return $donnees;
    }
 
    public function add_etud_groupe($numeroINE, $idGroupe){
        if (empty($idGroupe)) $idGroupe = 0;
 
        $req = self::$bdd->prepare('INSERT INTO apparteniraugroupe(numeroINE, idGroupe) values(?,?)');
        $req->execute(array($numeroINE, $idGroupe));
    }
 
    public function supprimer_groupe($idGroupe){
        $req = self::$bdd->prepare('DELETE FROM apparteniraugroupe where idGroupe=?');
        $req->execute(array($idGroupe));
 
        $req2 = self::$bdd->prepare('DELETE FROM groupe where idGroupe=?');
        $req2->execute(array($idGroupe));
    }
 
    public function nb_etud_dans_groupe($idGroupe){
        $req = self::$bdd->prepare('SELECT count(numeroINE) from apparteniraugroupe where idGroupe=?');
        $req->execute(array($idGroupe));
        $donnees = $req->fetch();
        return $donnees['count(numeroINE)'];
    }
 
    public function get_groupe_name($id){
        $req = self::$bdd->prepare('SELECT nomGroupe FROM groupe where idGroupe=?');
        $req->execute(array($id));
        $donnees = $req->fetch();
        return $donnees;
    }
}