<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['libelle']) && !empty($_POST['libelle'])
        && isset($_POST['id']) && !empty($_POST['id'])){
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $libelle = strip_tags($_POST['libelle']);
        $id = strip_tags($_POST['id']);

        $sql = 'INSERT INTO `Etat` (`libelle`,`id`) VALUES (:libelle, :id);';

        $query = $db->prepare($sql);

        $query->bindValue(':libelle', $libelle, PDO::PARAM_STR);
        $query->bindValue(':id', $id, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "libelle ajouté";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un libelle</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <h1>Ajouter un libelle</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="libelle">libelle</label>
                        <input type="text" id="libelle" name="libelle" class="form-control">
                        <div class="form-group">
                        <label for="prix">id</label>
                        <input type="text" id="id" name="id" class="form-control">
                    </div>
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>