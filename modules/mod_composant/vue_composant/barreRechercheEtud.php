<div class="container-fluid" style="border-bottom: 2px solid rgb(154, 154, 161);">
    <div class="row">

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 ">
            <span>Trier</span>

        <form action="index.php?module=etudiant&action=recherche" method="post">
                
            <select id="trier" class="custom-select" name="trie">
                <option value="prenomNomEtud" >prenom nom</option>
                <option value="numINE" >numeroINE</option>
                <option value="numApogee" >numero apogee</option>
                <option value="ecoleEntreprise" >Ecole/Entreprise</option>
            </select>
        </div>

        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 conteneurInputEtud mb-3">

            

            <input name=lieu id="elementRecherche" type="text" style="margin-top:2.5%;" class="form-control" placeholder="recherche...">

            <input type="submit" value="OK" style="margin-left: 100%;">

        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 conteneurInputEtud mb-3">
        </div>
    </div>
</div>