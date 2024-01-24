<?php

use App\class\Message;
use App\class\GeustBook;

$errors = null;
$success = false;

$geustbook = new GeustBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'message' );
if (isset($_POST['username'], $_POST["message"]))
{
    $message = new Message($_POST['username'], $_POST['message']);
    if ($message->isValid())
    {
        $geustbook->addMessage($message);
        $success = true;
        $_POST = [];
    }
    else
    {
        $errors = $message->getErros();
    }
}
$messages = $geustbook->getMessage();
?>

<h1 class="text-4xl font-bold text-blue-600">Livre d'or</h1>
<?php if (!empty($errors)): ?>
    <div class="w-full bg-red-100 rounded-md mt-4 text-blue-900 p-6">
        Formulaire invalide !
    </div>
<?php endif ?>

<?php if ($success): ?>   
    <div class="w-full bg-green-100 rounded-md mt-4 text-green-900 p-6">
        Merci pour votre message !
    </div>
<?php endif ?>

<form action="" method="post">
        <input 
            value="<?= htmlentities($_POST['username'])?>"
            type="text" 
            name="username" 
            placeholder="Pseudo" 
            class="border border-2 border-gray-400 px-3 py-2 rounded mb-5 mt-5"
        >
        <?php if (isset($errors['username'])): ?>
            <p class="text-red-500">
                <?= $errors['username']?>
            </p>
        <?php endif ?>      
        <br>
        <textarea 
        name="message" 
        placeholder="message" 
        class="border border-2 border-gray-400 px-3 py-2 rounded"
        ><?= htmlentities($_POST['message']) ?? '' ?></textarea>
        <?php if (isset($errors['message'])): ?>
            <p class="text-red-500">
                <?= $errors['message']?>
            </p>
        <?php endif ?>
        <br>
        <button class="bg-blue-600 text-white px-3 py-2 rounded-md focus:bg-blue-400 mb-4">Envoyer</button>
</form>
<hr>
<?php if (!empty($messages)): ?>
<h1 class="text-2xl font-bold text-blue-600">Vos messages</h1>
<?php foreach($messages as $message): ?>
    <?= $message->toHtml()?>
<?php endforeach ?>
<?php endif ?>