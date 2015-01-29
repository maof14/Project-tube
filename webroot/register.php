<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$user = new CUser($triton['database']);

if(isset($_POST['submit'])) {
	if($user->createUser()) {
		$feedback = 'Welcome! Your account has now been created.';
	} else {
		$feedback = "Oops, something went wrong.";
	}
} else {
	$feedback = null;
}

$triton['title'] = "Register";
$triton['main'] = <<<EOD
<h1>Create a user</h1>
<form method='post'>
<p>
<label>Username</label><br />
<input type='text' name='acronym' id='acronym' />
</p>
<p>
<label>Password</label><br />
<input type='password' name='password' id='password' />
</p>
<p>
<label>Repeat password</label><br />
<input type='password' name='repeatpassword' id='repeatpassword' />
</p>
<p>
<label>E-mail</label><br />
<input type='text' name='email' id='email' />
</p>
<p>
<label>Name</label><br />
<input type='text' name='name' id='name'>
</p>
<p>
<label>Write something about yourself</label><br />
<textarea name='text' id='text'></textarea>
</p>
<input type='submit' class='btn' name='submit' id='submit' value='Submit' />
<input type='reset' class='btn' value='Clear entries'>
</form>
<output>$feedback</output>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

