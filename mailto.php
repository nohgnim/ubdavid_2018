<?php

//Contact Information
$ContactName 		= $_POST['ContactName'];
$ContactPhone 		= $_POST['ContactPhone'];
$ContactEmail 		= $_POST['ContactEmail'];

//Business Information
$BusinessName 		= $_POST['BusinessName'];
$BusinessAddress 	= $_POST['BusinessAddress'];
$BusinessCity 		= $_POST['BusinessCity'];
$BusinessProv 		= $_POST['BusinessProv'];
$BusinessPhone 		= $_POST['BusinessPhone'];

//Billing Information
$BillingName 		= $_POST['BillingName'];
$BillingAddress 	= $_POST['BillingAddress'];
$BillingCity 		= $_POST['BillingCity'];
$BillingProv 		= $_POST['BillingProv'];
$BillingPC	 		= $_POST['BillingPC'];
$BillingPhone 		= $_POST['BillingPhone'];

//Lesson Booklets
$Storytime1 		= $_POST['Storytime1'];
$Storytime2 		= $_POST['Storytime2'];
$BestFriends1 		= $_POST['BestFriends1'];
$BestFriends2		= $_POST['BestFriends2'];
$Explorers1 		= $_POST['Explorers1'];
$Explorers2 		= $_POST['Explorers2'];
$CountryHeaven 		= $_POST['CountryHeaven'];
$TimelyTopics		= $_POST['TimelyTopics'];

$Instructions		= $_POST['Instructions'];

if (empty($ContactName) || empty($ContactEmail) || empty($ContactPhone)) {
	
	echo "You didn't give us any contact information to get back to you. If you could fill out the contact information that would be great!";
	
}

elseif (empty($Storytime1) && empty($Storytime2) && empty($BestFriends1) && empty($BestFriends2) && empty($Explorers1) && empty($Explorers2) && empty($CountryHeaven) && empty($TimelyTopics)) {

	echo "You didn't order any lesson booklets. Please go back and order the lesson booklets you would like.";
	
}

else {
	
$subject ="D&J Lesson Booklet Order Form";
$message="Contact Info:\n\nName: $ContactName \nPhone: $ContactPhone \nEmail: $ContactEmail \n\nCamp Information:\n\nName: $BusinessName\nAddress: $BusinessAddress\nCity: $BusinessCity\nProv: $BusinessProv\nPhone: $BusinessPhone\n\nBilling Info:\n\nName: $BillingName\nAddress: $BillingAddress\nCity: $BillingCity\nProv: $BillingProv\nPostal Code: $BillingPC\nPhone: $BillingPhone\n\nBooklets Ordered: \n\nStorytime 1: $Storytime1\nStorytime 2: $Storytime2\nBest Friends 1: $BestFriends1\nBest Friends 2: $BestFriends2\nExplorers 1: $Explorers1\nExplorers 2: $Explorers2\nCountry Called Heaven: $CountryHeaven\nTimely Topics: $TimelyTopics\n\nInstructions: $Instructions";
$mail_from="$ContactEmail";
$header="from: $ContactName <$mail_from>";
$to ='davidjonathan@shaw.ca';
$send_contact=mail($to,$subject,$message,$header);

	if($send_contact){
		  // Login success
		  header( "Refresh:5; url=http://ubdavid.org/camps/campordering_success.html", true, 303);
		  echo "<h3>Thank you for submitting the order form</h3>";
	   } else {
		  // Login failed
		  echo "<h3>Error, please try again later. Thank you.</h3>";
	   }
   
}

?>