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
session_start();

    if(isset($_SESSION['dbuser'])) {
        header('location: index.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $dbemail = $_POST['dbemail'];
        $dbuser = $_POST['dbuser'];
        $dbpwd = $_POST['dbpwd'];
        $dbpwd2 = $_POST['dbpwd2'];
        
        $dbpwd = hash('sha512', $dbpwd);
        $dbpwd2 = hash('sha512', $dbpwd2);
        
        $error = '';
        
        if (empty($dbemail) or empty($dbuser) or empty($dbpwd) or empty($dbpwd2)){
            
            $msg = _("Please complete all the fields");
$error .=  <<<EOT
<i>
$msg
</i><br /> 
EOT;
        }else{
            try{
                $dbconnect = new PDO('mysql:host=localhost;dbname=dicom_login', 'dbusername', 'dbsecret');
            }catch(PDOException $test_error){
                echo "Error: " . $test_error->getMessage();
            }
            
            $statement = $dbconnect->prepare('SELECT * FROM login WHERE dbuser = :dbuser LIMIT 1');
            $statement->execute(array(':dbuser' => $dbuser));
            $resultado = $statement->fetch();
            
                        
            if ($resultado != false){
$msg = _("This username is already registered");
$error .=  <<<EOT
<i>
$msg
</i><br /> 
EOT;
            }
            
            if ($dbpwd != $dbpwd2){
$msg = _("Passwords do not match");
$error .=  <<<EOT
<i>
$msg
</i><br /> 
EOT;
            }
            
            
        }
        
        if ($error == ''){
            $statement = $dbconnect->prepare('INSERT INTO login (id, dbemail, dbuser, dbpwd) VALUES (null, :dbemail, :dbuser, :dbpwd)');
            $statement->execute(array(
                
                ':dbemail' => $dbemail,
                ':dbuser' => $dbuser,
                ':dbpwd' => $dbpwd
                
            ));
            
$msg = _("The user has been successfully registered");
$error .=  <<<EOT
<i style="color: ligthgreen;">
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
                <label><img src="libs/images/email.svg" alt="email" style="max-width:1.2rem" /></label>
                <input type="text" placeholder='<?=_("eMail")?>' name="dbemail">
            </div>
            <div class="user line-input">
                <label><img src="libs/images/user-g.svg" alt="Username" style="max-width:1.2rem" /></label>
                <input type="text" placeholder='<?=_("Username")?>' name="dbuser" autocomplete="username">
            </div>
            <div class="password line-input">
                <label><img src="libs/images/padlock-g.svg" alt="Password" style="max-width:1.2rem" /></label>
                <input type="password" placeholder='<?=_("Password")?>' name="dbpwd" autocomplete="new-password">
            </div>
            <div class="password line-input">
                <label><img src="libs/images/padlock-g.svg" alt="Confirm Password" style="max-width:1.2rem" /></label>
                <input type="password" placeholder='<?=_("Confirm Password")?>' name="dbpwd2"
                    autocomplete="new-password">
            </div>

            <?php if(!empty($error)): ?>
            <div class="mensaje">
                <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <button type="submit"><?=_('Register')?></button>

        </form>
<?php
require("includes/logregfoot.php");
?>

