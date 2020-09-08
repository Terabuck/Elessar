<?php 
if(isset($_COOKIE["NG_TRANSLATE_LANG_KEY"])) {
    $lang = $_COOKIE["NG_TRANSLATE_LANG_KEY"];
    $directory=dirname(__FILE__)."/locale"; 
    $domain="messages"; 
    textdomain($domain); 
    setlocale(LC_MESSAGES,$lang); 
    bindtextdomain($domain, $directory); 
    bind_textdomain_codeset($domain, "UTF-8");
};
require("includes/localdefs.php");
session_start();
    if(isset($_SESSION['dbuser'])) {
        header('location: index.php');
    }
    $error = '';
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $dbuser = $_POST['dbuser'];
        $dbpwd = $_POST['dbpwd'];
        $dbpwd = hash('sha512', $dbpwd);
        
        try{
            $connection = new PDO('mysql:host=localhost;dbname=dicom_login', $connectionUser, $connectionPwd);
            }catch(PDOException $prueba_error){
                echo "Error: " . $prueba_error->getMessage();
            }
        
        $statement = $connection->prepare('
        SELECT * FROM login WHERE dbuser = :dbuser AND dbpwd = :dbpwd'
        );
        
        $statement->execute(array(
            ':dbuser' => $dbuser,
            ':dbpwd' => $dbpwd
        ));
            
        $resultado = $statement->fetch();
        
        if ($resultado !== false){
            $_SESSION['dbuser'] = $dbuser;
            header('location: explorer.php');
        }else{
$msg = _("This username is not registered");
$error .=  <<<EOT
<i>
$msg
</i><br /> 
EOT;
        }
    }
    
    require("includes/logreghead.php");
    ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form">
                <div class="welcome-form">
                    <h1><?=_('Access the')?></h1>
                    <h2><?=_('DICOM web')?></h2>
                </div>
                <div class="user line-input">
                    <label><img src="libs/images/user-g.svg" alt="Username" style="max-width:1.2rem" /></label>
                    <input type="text" placeholder='<?=_("Username")?>' name="dbuser" autocomplete="username">
                </div>
                <div class="password line-input">
                    <label><img src="libs/images/padlock-g.svg" alt="Password" style="max-width:1.2rem" /></label>
                    <input type="password" placeholder='<?=_("Password")?>' name="dbpwd" autocomplete="current-password">
                </div>
    
                <?php if(!empty($error)): ?>
                <div class="mensaje">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>
    
                <button type="submit"><?=_('Login')?></button>
    
                </form>
    <?php
    require("includes/logregfoot.php");
    ?>