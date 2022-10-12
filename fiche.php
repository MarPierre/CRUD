<?php
// On démarre une session
session_start();

// On inclut la connexion à la base
require_once('connect.php');

$sql = 'SELECT * FROM `FicheFrais`';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LigneFraisHorsForfait des libelles</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="libelle">
            <section class="col-12">
            <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <?php
                    if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message'].'
                            </div>';
                        $_SESSION['message'] = "";
                    }
                ?>
                <h1>FicheFrais des libelles</h1>
                <table class="table">
                    <thead>
                        <th>idVisiteur</th>
                        <th>mois</th>
                        <th>nbJustificatifs</th>
                        <th>montantValide</th>
                        <th>dateModif</th>
                        <th>idEtat</th>
                    </thead>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $libelle){
                        ?>
                            <tr>
                                <td><?= $libelle['idVisiteur'] ?></td>
                                <td><?= $libelle['mois'] ?></td>
                                <td><?= $libelle['nbJustificatifs'] ?></td>
                                <td><?= $libelle['montantValide'] ?></td>
                                <td><?= $libelle['dateModif'] ?></td>
                                <td>
                                            <!-- Liste déroulante MYSQL des libelle --><?php
                                            $bdd = new PDO('mysql:host=localhost;dbname=gsb','admin','password');?>
                                            <select name="libelle">
                                                <option value="-1"<?php if($libelle==-1){ echo 'selected="selected"'; } ?>>-- Choisissez --</option>
                                        <?php
                                            // ----------------
                                            // REQUETE SQL
                                            $sql='SELECT * FROM `Etat`';
                                            // ----------------
                                            // PREPARATION ET EXECUTION DE LA REQUETE
                                            $stmt = $bdd->prepare($sql);
                                            $stmt->execute();
                                            // ----------------
                                            $libelles = $stmt->fetchALL(); // on récupère TOUTES les lignes
                                            // ----------------
                                            foreach( $libelles as $libelle ) // une ligne à la fois
                                            {   
                                        ?>
                                                <option value="<?php echo $libelle['libelle']; ?>"<?php if($libelle==$libelle['libelle']){ echo ' selected="selected"'; } ?>>
                                                <?php echo $libelle['libelle'];?></option>
                                        <?php
                                            } 
                                            // ----------------
                                        ?>
                                            </select>
                                            <input type="submit" value="Valider" />
                                        </form>   
                                </td>
                            </tr>
				                        <?php 
	                                                }
	                                    ?>
                    </tbody>
                </table>
                <a href="index.php" class="btn btn-primary">Retour</a>
            </section>
        </div>
    </main>
</body>
</html>