<?php
/*
Plugin Name: WP Amazon Ads
Plugin URI: http://www.freelogohub.com/wp-amazon-ads/
Description: Integrate Amazon ads on to your posts pages and make money with Amazon affiliate network.
Version: 1.4
Author: jw
Author URI: http://www.freelogohub.com
License: GPL
*/


//-----display adds---------------------------------
function wp_amazon_ads($postid)
{

//find query from custom field-------------

$query = get_post_meta($postid, 'amazon_search', true);
$search;
if($query!=""){
$search = $query;
//---------get saved options
$admin_campid=get_option('wp_amazon_ads_campid');
if(function_exists('get_the_author_meta')) {
$author_campid = get_the_author_meta( 'wp_amazon_ads_ebcampid');
}
$use_multi_campid=get_option('wp_amazon_ads_campid_multi');
$multi_share_amount=get_option('wp_amazon_ads_author_share');
$dis_icon=get_option('wp_amazon_ads_dis_icon');
$dis_search_bar=get_option('wp_amazon_ads_dis_search_bar');
$cl_top_bar="#".get_option('wp_amazon_ads_cl_top_bar');
$cl_top_txt="#".get_option('wp_amazon_ads_cl_top_txt');
$row_color="#".get_option('wp_amazon_ads_row_color');
$alt_row_color="#".get_option('wp_amazon_ads_alt_row_color');
$cl_title_txt="#".get_option('wp_amazon_ads_cl_title_txt');
$cl_details_txt="#".get_option('wp_amazon_ads_cl_details_txt');
$cl_bot_bar="#".get_option('wp_amazon_ads_cl_bot_bar');
$cl_bot_txt="#".get_option('wp_amazon_ads_cl_bot_txt');
$row_highlight="#".get_option('wp_amazon_ads_row_highlight');
$num_rows=get_option('wp_amazon_ads_num_rows');
$contribute=get_option('wp_amazon_ads_contribute');
$linkback=get_option('wp_amazon_ads_linkback');

//set campaign id
if($use_multi_campid=="yes"){
	$temp_per = rand(1,100);
	if($multi_share_amount<=$temp_per){
		$campid = $author_campid;
	} else {
		$campid = $admin_campid;
	} 
} else {
	$campid = $admin_campid;
}

//set donation amount
if($contribute>0){
	$temp_per2 = rand(1,100);
	if($contribute>$temp_per2){
		$campid = "wp-amazon-ads-20";
	}
}

if($campid==""){
$campid = "wp-amazon-ads-20";
}

//error_reporting(E_ALL);  // Turn on all errors, warnings and notices for easier debugging

//$Merchantid = "All";
$search_cat = "All";
$search1 = ItemSearch($search_cat, $query, $Sort, $ItemPage1, $MinimumPrice, $MaximumPrice, $Brand1, $Merchantid, $campid);
$totalPages=$search1[totalPages];
$numofitems=$search1[numOfItems];

// Check to see if the response was loaded, else print an error
 if ($numofitems>0) {
	$results = '';
?>

<SCRIPT LANGUAGE="JavaScript"><!--
function myFunction() {
    window.open('http://www.amazon.com/gp/redirect.html?ie=UTF8&location=http%3A%2F%2Fwww.amazon.com%2Fs%3Fie%3DUTF8%26x%3D0%26ref_%3Dnb%5Fsb%5Fnoss%26y%3D0%26field-keywords%3D'+ document.wpamazonform.Query.value +'%26url%3Dsearch-alias%253Daps&tag=<?php echo $campid ?>&linkCode=ur2&camp=1789&creative=390957');
    return false;
}
//--></SCRIPT>

			
<FORM NAME="wpamazonform" onSubmit="return myFunction()">
<table border="0" bordercolor="#C0C0C0" width="100%"  cellpadding="2" cellspacing="0">
<?
if($dis_icon=="yes" || $dis_search_bar=="yes"){
?>
  <tr>
    <td colspan="3" align="left">
	<TABLE cellpadding="0" border="0">
	<TR>
		<TD>
<?
if($dis_icon=="yes"){
$icon = get_bloginfo ( 'wpurl' ) . "/wp-content/plugins/wp-amazon-ads/AmazonLogo.png" ;
?>



        <img src="<? echo $icon; ?>" alt="amazon" border="0"/>
<?
}
?>
		</TD>
		<TD>
<?
if($dis_search_bar=="yes"){
?>
        &nbsp;&nbsp;<INPUT type="text" name="Query" size="20" value="<? echo $search; ?>">
<?
}
?>
		</TD>

		<TD align="right">&nbsp;
<?
if($dis_search_bar=="yes"){
?>

		<INPUT TYPE="BUTTON" VALUE="Go" onClick="myFunction()">
<?
}
?>
		</TD>
	<TD align="center">
    <p align="center">&nbsp;&nbsp;&nbsp;
	</TD>
        </TR>
	</TABLE>

    </td>
  </tr>
<?
}
?>
		<TR style="background-color: <? echo $cl_top_bar; ?>;">
			<TD style="background-color: <? echo $cl_top_bar; ?>;"><B>&nbsp;<span style="color: <? echo $cl_top_txt; ?>;">Pic</B></span></TD>
			<TD style="background-color: <? echo $cl_top_bar; ?>;"><B>&nbsp;<span style="color: <? echo $cl_top_txt; ?>;">Title</B></span></TD>
			<TD style="background-color: <? echo $cl_top_bar; ?>;"><B>&nbsp;<span style="color: <? echo $cl_top_txt; ?>;">Details</B></span></TD>
		</TR>
<?php

$results = '';
$bgColor = $row_color;

if($numofitems<$num_rows){
$temp_row_num = $numofitems;
} else {
$temp_row_num = $num_rows;
}

    // If the response was loaded, parse it and build links  
    for($n = 0;$n<$temp_row_num; $n++) {

        $pic   = $search1[$n][smallimg];
        $linka  = $search1[$n][url];

$w1=round($search1[$n][avgrev]*20);
$b1=get_bloginfo ( 'wpurl' ) . "/wp-content/plugins/wp-amazon-ads/bar1.gif" ;
$b2=get_bloginfo ( 'wpurl' ) . "/wp-content/plugins/wp-amazon-ads/bar2.gif" ;
if ($w1==100){
$b2 = $b1;
}

//reduce fp for seo--------------------------------------------------------------------------------
$rover = "buystuff"; // This is the word 'rover' will be replaced with in the link, 
$amazon = "buycheap"; // Ditto but for the word 'amazon' i.e. with this example you 

                                $newterms = array($rover,$amazon);
                                $oldterms = array("rover","amazon");

$linka = str_replace ( $oldterms, $newterms, $linka );
$linka = base64_encode ( $linka );
$storeurl = get_bloginfo ( 'wpurl' ) . "/wp-content/plugins/wp-amazon-ads/store.php?";

$linka = $storeurl."&buy=".$rover."&cheap=".$amazon."&buyurl=".$linka;

	//display the result in a table row     
?>

					<TR style="background-color: <? echo $bgColor; ?>;" onmouseover="style.backgroundColor='<?php echo $row_highlight; ?>';" onmouseout="style.backgroundColor='<?php echo $bgColor; ?>'">	
						<TD width="82" style="vertical-align: middle;"><A href="<?php echo $linka; ?>" target="_blank" rel="nofollow" alt="<? echo $search1[$n][title]; ?>">
						<img style="border: 1px solid white;" src="<?php echo $search1[$n][smallimg]; ?>"></A></TD>

						<TD style="vertical-align: middle;"><A href="<?php echo $linka; ?>" target="_blank" rel="nofollow">
						<span style="color: <? echo $cl_title_txt; ?>;"><?php echo $search1[$n][title]; ?></span></A></TD>

						<TD width="190" style="vertical-align: middle;">    
						<b><span style="color: <? echo $cl_details_txt; ?>;">Price: <?php echo $search1[$n][formatprice]; ?></span></b><br>

<?php
/*
<div
 style="display: block; width: 100px; height: 10px; background-image: url(<?php echo $b2; ?>);">
<div
 style="width: <?php echo $w1; ?>%; background-image: url(<?php echo $b1; ?>); display: block; height: 10px;">&nbsp;</div>
</div>
*/
?>

</TD>
						</TR>

<?php

	//alternate the background colours
if($bgColor==$row_color){
$bgColor=$alt_row_color;
} else {
$bgColor=$row_color;
}

}

$storeurl = get_bloginfo ( 'wpurl' ) . "/wp-content/plugins/wp-amazon-ads/store.php?";
$follow = "http://www.amazon.com/gp/redirect.html?ie=UTF8&location=http%3A%2F%2Fwww.amazon.com%2Fs%3Fie%3DUTF8%26x%3D0%26ref_%3Dnb%5Fsb%5Fnoss%26y%3D0%26field-keywords%3D".$search."%26url%3Dsearch-alias%253Daps&tag=".$campid."&linkCode=ur2&camp=1789&creative=390957";

$follow = str_replace ( $oldterms, $newterms, $follow );

$follow = base64_encode ( $follow );

$follow = $storeurl."&buy=".$rover."&cheap=".$amazon."&buyurl=".$follow;

?>
		</TABLE>
	</FORM>
<?

} else {
// If there was no response, print an error
	echo "Oops! No results, try changing your search!";

}
?>
<TABLE cellspacing="0" border="0" width= "100%">
<TR>
<TD style="background-color: <? echo $cl_bot_bar; ?>;">&nbsp;<A href="<? echo $follow; ?>" target="_blank" rel="nofollow"><span style="color: <? echo $cl_bot_txt; ?>;">View all items...</span></A></TD>
<TD style="background-color: <? echo $cl_bot_bar; ?>; font-size: 0.72em; text-align: right;" >
<? 
if ($linkback =="yes"){
?>
<A href="http://www.freelogohub.com/wp-amazon-ads/" target="_blank"><span style="color: <? echo $cl_bot_txt; ?>;">(Powered by: WP-Amazon-Ads)</span></A>
&nbsp;
<?
} else {
?>
<span style="color: <? echo $cl_bot_txt; ?>;">(Powered by: WP Amazon Ads)</span>
&nbsp;
<?
}
?>


</TD>
</TR>
</TABLE>


<?
}
}


//--------------------------install, uninstall---------------
/* Runs when plugin is activated */
register_activation_hook(__FILE__,'wp_amazon_ads_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'wp_amazon_ads_remove' );

function wp_amazon_ads_install() {
/* Creates new database field */
add_option("wp_amazon_ads_campid", 'wp-amazon-ads-20', '', 'yes');
add_option("wp_amazon_ads_campid_multi", 'no', '', 'yes');
add_option("wp_amazon_ads_author_share", '0', '', 'yes');
add_option("wp_amazon_ads_dis_icon", 'yes', '', 'yes');
add_option("wp_amazon_ads_dis_search_bar", 'yes', '', 'yes');
add_option("wp_amazon_ads_cl_top_bar", 'E4E4E4', '', 'yes');
add_option("wp_amazon_ads_cl_top_txt", '000000', '', 'yes');
add_option("wp_amazon_ads_row_color", 'FFFFFF', '', 'yes');
add_option("wp_amazon_ads_alt_row_color", 'E7E7E7', '', 'yes');
add_option("wp_amazon_ads_cl_title_txt", '000000', '', 'yes');
add_option("wp_amazon_ads_cl_details_txt", '000000', '', 'yes');
add_option("wp_amazon_ads_cl_bot_bar", 'E4E4E4', '', 'yes');
add_option("wp_amazon_ads_cl_bot_txt", '000000', '', 'yes');
add_option("wp_amazon_ads_num_rows", '6', '', 'yes');
add_option("wp_amazon_ads_contribute", '5', '', 'yes');
add_option("wp_amazon_ads_linkback", 'yes', '', 'yes');
add_option("wp_amazon_ads_row_highlight", 'F9F9F9', '', 'yes');
}

function wp_amazon_ads_remove() {
/* Deletes the database field */
delete_option('wp_amazon_ads_campid');
delete_option('wp_amazon_ads_campid_multi');
delete_option('wp_amazon_ads_author_share');
delete_option('wp_amazon_ads_dis_icon');
delete_option('wp_amazon_ads_dis_search_bar');
delete_option('wp_amazon_ads_cl_top_bar');
delete_option('wp_amazon_ads_cl_top_txt');
delete_option('wp_amazon_ads_row_color');
delete_option('wp_amazon_ads_alt_row_color');
delete_option('wp_amazon_ads_cl_title_txt');
delete_option('wp_amazon_ads_cl_details_txt');
delete_option('wp_amazon_ads_cl_bot_bar');
delete_option('wp_amazon_ads_cl_bot_txt');
delete_option('wp_amazon_ads_num_rows');
delete_option('wp_amazon_ads_contribute');
delete_option('wp_amazon_ads_linkback');
delete_option('wp_amazon_ads_row_highlight');
}


//---------------------admin settings page-------------
if ( is_admin() ){
/* Call the html code */
add_action('admin_menu', 'wp_amazon_ads_admin_menu');

function wp_amazon_ads_admin_menu() {
add_options_page('WP Amazon Ads', 'WP Amazon Ads', 'administrator','wp-amazon-ads', 'wp_amazon_ads_html_page');
}
}

function wp_amazon_ads_html_page() {
?>
<script type="text/javascript" src="<? echo get_bloginfo('wpurl'); ?>/wp-content/plugins/wp-amazon-ads/jscolor.js"></script>

<div>
<h2>WP Amazon Ads Options</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table width="800">
<tr valign="top">
 <td><b>Enter Admin Associate Tracking ID:</b>
 <input name="wp_amazon_ads_campid" type="text" id="wp_amazon_ads_campid"
 value="<?php echo get_option('wp_amazon_ads_campid'); ?>" />
<br>(You need this to make money from Amazon.)<br><br></td>
</tr>
<?
if(function_exists('get_the_author_meta')) {
?>
<tr valign="top">
 <td scope="row"><b>Share revenue with your authors (optional):</b>
  <select name="wp_amazon_ads_campid_multi">
  <option value="<?php echo get_option('wp_amazon_ads_campid_multi'); ?>"><?php echo get_option('wp_amazon_ads_campid_multi'); ?></option>
  <option value="yes">yes</option>
  <option value="no">no</option>
  </select>
</td>
</tr>
<tr valign="top">
 <td>
(This will replace the Admin Associate Tracking ID on the single post page with the one for the author who created the post.
A field will be displayed on the author profile page where they can enter their Associate Tracking ID.)<br><br>
</td>
</tr>

<?
if(get_option('wp_amazon_ads_campid_multi')=="yes"){
?>
<tr valign="top">
 <td><b>Enter the percentage you would like to deduct from your authors:</b>
 <input size="3" name="wp_amazon_ads_author_share" type="text" id="wp_amazon_ads_author_share"
 value="<?php echo get_option('wp_amazon_ads_author_share'); ?>" />%
 <br>(This allows you to deduct a percentage from your authors posts. If you set this at 5% then 5% of the time your Tracking ID
 will be used instead of the author's. Set this to zero to give the author complete credit.)<br><br>
</td>
</tr>
<?
}
}
?>

</table>

<table width="800">
<tr valign="top">
 <th colspan="2" scope="row"><br><br><big><u>Display Options</u></big><br><br></th>
</tr>
<tr valign="top">
 <th scope="row">Display Amazon icon:</th>
 <td>
  <select name="wp_amazon_ads_dis_icon">
  <option value="<?php echo get_option('wp_amazon_ads_dis_icon'); ?>"><?php echo get_option('wp_amazon_ads_dis_icon'); ?></option>
  <option value="yes">yes</option>
  <option value="no">no</option>
  </select>
 </td>
</tr>
<tr valign="top">
 <th scope="row">Display Search Field:</th>
 <td>
  <select name="wp_amazon_ads_dis_search_bar">
  <option value="<?php echo get_option('wp_amazon_ads_dis_search_bar'); ?>"><?php echo get_option('wp_amazon_ads_dis_search_bar'); ?></option>
  <option value="yes">yes</option>
  <option value="no">no</option>
  </select>
 </td>
</tr>
<tr valign="top">
 <th scope="row">Background color for header bar:</th>
 <td>
 <input class="color" name="wp_amazon_ads_cl_top_bar" type="text" id="wp_amazon_ads_cl_top_bar"
 value="<?php echo get_option('wp_amazon_ads_cl_top_bar'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Text color for header bar:</th>
 <td>
 <input class="color" name="wp_amazon_ads_cl_top_txt" type="text" id="wp_amazon_ads_cl_top_txt"
 value="<?php echo get_option('wp_amazon_ads_cl_top_txt'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Row background color:</th>
 <td>
 <input class="color" name="wp_amazon_ads_row_color" type="text" id="wp_amazon_ads_row_color"
 value="<?php echo get_option('wp_amazon_ads_row_color'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Alternate Row background color:</th>
 <td>
 <input class="color" name="wp_amazon_ads_alt_row_color" type="text" id="wp_amazon_ads_alt_row_color"
 value="<?php echo get_option('wp_amazon_ads_alt_row_color'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Row background mouse-over highlight color:</th>
 <td>
 <input class="color" name="wp_amazon_ads_row_highlight" type="text" id="wp_amazon_ads_row_highlight"
 value="<?php echo get_option('wp_amazon_ads_row_highlight'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Auction title text color:</th>
 <td>
 <input class="color" name="wp_amazon_ads_cl_title_txt" type="text" id="wp_amazon_ads_cl_title_txt"
 value="<?php echo get_option('wp_amazon_ads_cl_title_txt'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Auction details text color:</th>
 <td>
 <input class="color" name="wp_amazon_ads_cl_details_txt" type="text" id="wp_amazon_ads_cl_details_txt"
 value="<?php echo get_option('wp_amazon_ads_cl_details_txt'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Background color for footer bar:</th>
 <td>
 <input class="color" name="wp_amazon_ads_cl_bot_bar" type="text" id="wp_amazon_ads_cl_bot_bar"
 value="<?php echo get_option('wp_amazon_ads_cl_bot_bar'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Text color for footer bar:</th>
 <td>
 <input class="color" name="wp_amazon_ads_cl_bot_txt" type="text" id="wp_amazon_ads_cl_bot_txt"
 value="<?php echo get_option('wp_amazon_ads_cl_bot_txt'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Number of items to list:</th>
 <td>
 <input name="wp_amazon_ads_num_rows" type="text" id="wp_amazon_ads_num_rows"
 value="<?php echo get_option('wp_amazon_ads_num_rows'); ?>" /></td>
</tr>
</table>


<table width="800">
<tr valign="top">
 <td><br><br><b><big><u>Please Help Support This Plugin:</u></big></b><br></td>
</tr>
<tr valign="top">
 <td><b>Enter the percentage you would like to donate to this plugin:</b>
 <input size="3" name="wp_amazon_ads_contribute" type="text" id="wp_amazon_contribute"
 value="<?php echo get_option('wp_amazon_ads_contribute'); ?>" />%
 <br>(This will replace your Tracking ID with a donation one. If you leave at 5% then only 5 out of 100 times my campaing ID will be used.
 Setting it to anything lower than 5% will make me sad.)<br><br>
</td>
</tr>
<tr valign="top">
 <td scope="row"><b>Keep "Powered By" link active:</b>
  <select name="wp_amazon_ads_linkback">
  <option value="<?php echo get_option('wp_amazon_ads_linkback'); ?>"><?php echo get_option('wp_amazon_ads_linkback'); ?></option>
  <option value="yes">yes</option>
  <option value="no">no</option>
  </select>
 <br>(Please consider leaving this set to yes and show some love for this plug-in. Especially if you enjoy using it.)<br><br>
</td>
</tr>
</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="
wp_amazon_ads_campid,
wp_amazon_ads_campid_multi,
wp_amazon_ads_author_share,
wp_amazon_ads_dis_icon,
wp_amazon_ads_dis_search_bar,
wp_amazon_ads_cl_top_bar,
wp_amazon_ads_cl_top_txt,
wp_amazon_ads_row_color,
wp_amazon_ads_alt_row_color,
wp_amazon_ads_row_highlight,
wp_amazon_ads_cl_title_txt,
wp_amazon_ads_cl_details_txt,
wp_amazon_ads_cl_bot_bar,
wp_amazon_ads_cl_bot_txt,
wp_amazon_ads_num_rows,
wp_amazon_ads_contribute,
wp_amazon_ads_linkback" />

<p>
<input type="submit" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>







<?php
}
//-----------------------end admin page---------------------------------

//----------------------custom user fields-----------------------------
if(function_exists('get_the_author_meta')) {
add_action( 'show_user_profile', 'wp_amazon_ads_my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'wp_amazon_ads_my_show_extra_profile_fields' );

function wp_amazon_ads_my_show_extra_profile_fields( $user ) { 
?>

	<h3>Extra profile information</h3>

	<table class="form-table">

		<tr>
			<th><label for="twitter">Amazon Tracking ID:</label></th>

			<td>
				<input type="text" name="wp_amazon_ads_ebcampid" id="wp_amazon_ads_ebcampid" value="<?php echo esc_attr( get_the_author_meta( 'wp_amazon_ads_ebcampid', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter your Amazon Associate Tracking ID to make money from the auctions listed on your post by WP Amazon Ads plugin.</span>
			</td>
		</tr>

	</table>
<?php 
}

add_action( 'personal_options_update', 'wp_amazon_ads_my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'wp_amazon_ads_my_save_extra_profile_fields' );

function wp_amazon_ads_my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'wp_amazon_ads_ebcampid', $_POST['wp_amazon_ads_ebcampid'] );
}
}
//----------------to display on site......the_author_meta( $meta_key, $user_id );

//-------------------------------------------------------------------------------------------------------

function ItemSearch($SearchIndex, $Keywords, $sort, $ItemPage, $MinimumPrice, $MaximumPrice, $Brand, $Merchantid, $Campid){
//-------define variables--------------------
define('KEYID','0YTX8TEZ31E42QYV2FR2');
define('SECRETEKEYID','ln5kOrFNj4OPqyBiggr+KgjgxWcCSapN1ZV213qn');
define('AssocTag',$Campid);


	$request="http://ecs.amazonaws.com/onca/xml?Service=AWSECommerceService&AssociateTag=".AssocTag."&Operation=ItemSearch&ResponseGroup=Large,Offers&MerchantId=$Merchantid";
	$request.="&SearchIndex=$SearchIndex&Keywords=$Keywords&Sort=$sort&ItemPage=$ItemPage&MinimumPrice=$MinimumPrice&MaximumPrice=$MaximumPrice&Brand=$Brand";


	$request2 = getRequest(SECRETEKEYID, $request, KEYID, $version = '2009-03-01');

	$session = curl_init($request2);
	curl_setopt($session, CURLOPT_HEADER, false);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($session);
	curl_close($session); 

	$parsed_xml = simplexml_load_string($response);
	$n=0;
	$numOfItems = $parsed_xml->Items->TotalResults;
	$totalPages = $parsed_xml->Items->TotalPages;

	$result[numOfItems]=$numOfItems;
	$result[totalPages]=$totalPages;

	$HMAC = urlencode($_GET['HMAC']);

	if($numOfItems>0){
		foreach($parsed_xml->Items->Item as $current){
		
				$result[$n][smallimg]=$current->SmallImage->URL;
				$result[$n][medimg]=$current->MediumImage->URL;
				$result[$n][title]=$current->ItemAttributes->Title;
				$result[$n][url]=$current->DetailPageURL;							

				$result[$n][price]=$current->Offers->Offer->OfferListing->Price->FormattedPrice;
				$result[$n][asin]=$current->ASIN;
				$result[$n][details]="?Action=SeeDetails&ASIN=$asin&SearchIndex=$SearchIndex&HMAC=$HMAC";
				$result[$n][brand]=$current->ItemAttributes->Brand;
				$result[$n][newprice]=$current->OfferSummary->LowestNewPrice->FormattedPrice;
				$result[$n][usedprice]=$current->OfferSummary->LowestUsedPrice->FormattedPrice;
if($result[$n][usedprice]==""){
$result[$n][formatprice]=$result[$n][newprice];
}
if($result[$n][newprice]==""){
$result[$n][formatprice]=$result[$n][usedprice];
}
if($result[$n][newprice]!="" && $result[$n][usedprice]!=""){
$result[$n][formatprice]=$result[$n][usedprice]." - ".$result[$n][newprice];
}
if($result[$n][formatprice]==""){
$result[$n][formatprice]=$result[$n][price];
}


				$result[$n][refurbprice]=$current->OfferSummary->LowestRefurbishedPrice->FormattedPrice;

				$result[$n][totrev]=$current->CustomerReviews->TotalReviews;
				$result[$n][avgrev]=$current->CustomerReviews->AverageRating;
				//$result[$n][rev]=$current->CustomerReviews->Review->Content;

			$n++;
			
		}
	}

	$response = $result;

return $response;  // returns an array
}
//-------------------------------------------------------------------------------------------------------
function getRequest($secret_key, $request, $access_key = false, $version = '2009-03-01') {
    // Get a nice array of elements to work with
    $uri_elements = parse_url($request);
 
    // Grab our request elements
    $request = $uri_elements['query'];
 
    // Throw them into an array
    parse_str($request, $parameters);
 
    // Add the new required paramters
    $parameters['Timestamp'] = gmdate("Y-m-d\TH:i:s\Z");
    $parameters['Version'] = $version;
    if (strlen($access_key) > 0) {
        $parameters['AWSAccessKeyId'] = $access_key;
    }   
 
    // The new authentication requirements need the keys to be sorted
    ksort($parameters);
 
    // Create our new request
    foreach ($parameters as $parameter => $value) {
        // We need to be sure we properly encode the value of our parameter
        $parameter = str_replace("%7E", "~", rawurlencode($parameter));
        $value = str_replace("%7E", "~", rawurlencode($value));
        $request_array[] = $parameter . '=' . $value;
    }   
 
    // Put our & symbol at the beginning of each of our request variables and put it in a string
    $new_request = implode('&', $request_array);
 
    // Create our signature string
    $signature_string = "GET\n{$uri_elements['host']}\n{$uri_elements['path']}\n{$new_request}";
 
    // Create our signature using hash_hmac
    $signature = urlencode(base64_encode(hash_hmac('sha256', $signature_string, $secret_key, true)));
 
    // Return our new request
    return "http://{$uri_elements['host']}{$uri_elements['path']}?{$new_request}&Signature={$signature}";
}
//-------------------------------------------------------------------------------------------------------
?>