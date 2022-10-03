<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * This function is used to print the content of any data
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * This function used to get the CI instance
 */
if(!function_exists('get_instance'))
{
    function get_instance()
    {
        $CI = &get_instance();
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}

/**
 * This method used to get current browser agent
 */
if(!function_exists('getBrowserAgent'))
{
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser())
        {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        else if ($CI->agent->is_robot())
        {
            $agent = $CI->agent->robot();
        }
        else if ($CI->agent->is_mobile())
        {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}

if(!function_exists('setProtocol'))
{
    function setProtocol()
    {
        $CI = &get_instance();
                    
        $CI->load->library('email');
        
        $config['protocol'] = PROTOCOL;
        $config['mailpath'] = MAIL_PATH;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['smtp_user'] = SMTP_USER;
        $config['smtp_pass'] = SMTP_PASS;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        
        $CI->email->initialize($config);
        
        return $CI;
    }
}

if(!function_exists('emailConfig'))
{
    function emailConfig()
    {
        $CI = &get_instance();
        $CI->load->library('email');
        $config['protocol'] = PROTOCOL;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['mailpath'] = MAIL_PATH;
        $config['charset'] = 'UTF-8';
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
    }
}

if(!function_exists('resetPasswordEmail'))
{
    function resetPasswordEmail($detail)
    {
        $data["data"] = $detail;
        // pre($detail);
        // die;
        
        $CI = setProtocol();        
        
        $CI->email->from(EMAIL_FROM, FROM_NAME);
        $CI->email->subject("Reset Password");
        $CI->email->message($CI->load->view('email/resetPassword', $data, TRUE));
        $CI->email->to($detail["email"]);
        $status = $CI->email->send();
        
        return $status;
    }
}

if(!function_exists('setFlashData'))
{
    function setFlashData($status, $flashMsg)
    {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }
}

// cyogate functions =========================================
function sendXMLviaCurl($xmlRequest,$gatewayURL) {
         // helper function demonstrating how to send the xml with curl


          $ch = curl_init(); // Initialize curl handle
          curl_setopt($ch, CURLOPT_URL, $gatewayURL); // Set POST URL

          $headers = array();
          $headers[] = "Content-type: text/xml";
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Add http headers to let it know we're sending XML
          $xmlString = $xmlRequest->saveXML();
          curl_setopt($ch, CURLOPT_FAILONERROR, 1); // Fail on errors
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Allow redirects
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return into a variable
          curl_setopt($ch, CURLOPT_PORT, 443); // Set the port number
          curl_setopt($ch, CURLOPT_TIMEOUT, 15); // Times out after 15s
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlString); // Add XML directly in POST

          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);


          // This should be unset in production use. With it on, it forces the ssl cert to be valid
          // before sending info.
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

          if (!($data = curl_exec($ch))) {
              print  "curl error =>" .curl_error($ch) ."\n";
              throw New Exception(" CURL ERROR :" . curl_error($ch));

          }
          curl_close($ch);

          return $data;
        }

        // Helper function to make building xml dom easier
        function appendXmlNode($domDocument, $parentNode, $name, $value) {
              $childNode      = $domDocument->createElement($name);
              $childNodeValue = $domDocument->createTextNode($value);
              $childNode->appendChild($childNodeValue);
              $parentNode->appendChild($childNode);
        }


      function getActivationKay($length_of_string) 
      { 
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZAABBCCDDEEFFGGHHIIJJKKLLMMNNOOPPQQRRSST'; 
          $string  =substr(str_shuffle($str_result),  
                             0, $length_of_string); 
          $str1 = substr_replace($string,"-", 4, -strlen($string));
          $str1 = substr_replace($str1,"-", 9, -strlen($str1));
          return $str2 = substr_replace($str1,"-", 14, -strlen($str1));
      }        
// End cyogate functions =====================================

        function mailTemplate($orderData, $userData, $productData,$productKeyData,$mailtype){
          $productarray = json_decode($orderData->products,true);
          // echo "<pre>";
          // print_r($productData);
          // print_r($productData);
          // print_r($productKeyData);
          // print_r($productarray);
          $autorenewal = ($productarray['renewal'] == "on")?" <br/><small>(Automatic Renewal at $29.00 after the first year.)</small> ":'';
          $licenceKey = ($productKeyData[0]->productKey == "N")?"Contact With Our Customer Care":$productKeyData[0]->productKey;
          $dateis= date("M d, Y", strtotime($orderData->date_at));
          
          if($mailtype == "Customer"){
          $hiUser = "Hi ".$userData->fname;
          $headerMessage = 'Thank you for ordering from Ale-izba.com on '.$dateis.'. Please retain this email for your records. For payment issued with a credit card, please look for transaction record that shows "Ale-izba" on your card billing statement.';
          }else{
            $hiUser = "Hi Admin";
            $headerMessage = 'Ale-izba new customer order on '.$dateis.'.';
          }


           // foreach ($productarray['product'] as $key => $productId) {
           // $productTable = "<tr bgcolor='#fff' ><td style='padding: 3px' ><div class='productConSuccess' style='font-size: 12px;line-height: 10px;color: #333;' >".$productData[$productId]['name']."</div></td></tr><tr  bgcolor='#fff' ><td style='padding: 3px;font-size:15px' ><b>Price:</b> $".$productData[$productId]['price']."</td></tr><tr  bgcolor='#fff' ><td style='font-size: 14px;'><b>Quantity: </b>".$productarray['no_item'][$productId]."</td></tr><tr  bgcolor='#fff' style='border-bottom: 2px solid #cecbcb;' ><td style='padding-bottom:10px;font-size: 14px;' ><b>Total :</b> $".number_format($productarray['no_item'][$productId]*$productData[$productId]['price'],2)." </td></tr>";
           //  }
          $htmlContent = '<table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" bgcolor="#f9fafc" style="background-color:rgb(249,250,252)">

                    <tbody><tr>
                        <td align="center" valign="top">
                        
                            <table border="0" cellpadding="0" cellspacing="0" width="590" style=" border:1px solid #8a8a8a;max-width:590px!important;width:590px">
                        <tbody><tr>

                        <td align="center" valign="top">

                            
                            </td>
                    </tr><tr>

                        <td align="center" valign="top">

                            <div style="background-color:rgb(255,255,255);border-radius:0px">
                                
                                
                                
                                
                                <table width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:590px" name="Layout_1" id="m_-2647993506786989335m_-1692576443445193334m_-2044590671222991195Layout_1">
                                <tbody><tr>
                                    <td align="center" valign="top" style="min-width:590px">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="background-color:rgb(255,255,255);border-radius:0px;padding-left:20px;padding-right:20px;border-collapse:separate">
                                            <tbody><tr>
                                                <td height="20" style="font-size:1px;line-height:0px">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td valign="top" align="left">
                                                    <table width="100%" cellpadding="0" border="0" align="center" cellspacing="0">
                                                        <tbody><tr>
                                                            <td valign="top" align="center">
                                                                <table cellpadding="0" border="0" align="center" cellspacing="0"> 
                                                                    <tbody><tr>
                                                                        <td valign="middle" align="center" style="line-height:1px">
                                                                            <div style="border-top:0px None #9c9c9c;border-right:0px None #9c9c9c;border-bottom:0px None #9c9c9c;border-left:0px None #9c9c9c;display:inline-block" cellspacing="0" cellpadding="0" border="0"><div><img width="550" vspace="0" hspace="0" border="0" alt="Ale-izba.com" style="float:left;max-width:550px;display:block" src="https://Ale-izba.com/assets/images/computeriods-logo-22.png" class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 0.01; left: 702px; top: 334px;"><div id=":1by" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Download attachment " data-tooltip-class="a1V" data-tooltip="Download"><div class="aSK J-J5-Ji aYr"></div></div></div></div></div></td>
                                                                    </tr>
                                                                </tbody></table>
                                                                </td>
                                                        </tr>
                                                    </tbody></table></td>
                                            </tr>
                                            <tr>
                                                <td height="20" style="font-size:1px;line-height:0px">&nbsp;</td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                            </tbody></table>
                            
                                
                                
                            
                        </div></td>
                    </tr><tr>

                        <td align="center" valign="top">

                            <div style="background-color:rgb(255,255,255);border-radius:0px">
                                
                                
                                
                                
                            
                                <table width="100%" cellpadding="0" border="0" cellspacing="0" name="Layout_" id="m_-2647993506786989335m_-1692576443445193334m_-2044590671222991195Layout_"><tbody><tr>
                                    <td align="center" valign="top">
                                        <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="height:0px;background-color:rgb(255,255,255);border-radius:0px;border-collapse:separate;padding-left:20px;padding-right:20px"><tbody><tr>
                                                <td>

                                                    <table border="0" cellpadding="0" cellspacing="0" align="left" style="margin:auto">
                                                        <tbody><tr>

                                                            <th align="left" style="text-align:center;font-weight:normal">

                                                                <table border="0" cellspacing="0" cellpadding="0" align="center">

                                                                    <tbody><tr>
                                                                        <td height="10"></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td style="font-family:Arial,Helvetica,sans-serif;color:#3c4858;text-align:left">

                                                                            <span style="color:#3c4858"><span style="font-size:19px"><strong>'.$hiUser.'</strong></span></span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="10"></td>
                                                                    </tr>
                                                                    </tbody></table>
                                                                </th></tr>
                                                    </tbody></table></td>
                                            </tr>

                                        </tbody></table>

                                    </td>
                                </tr>

                            </tbody></table>
                                
                                
                            
                        </div></td>
                    </tr><tr>

                        <td align="center" valign="top">

                            <div style="background-color:rgb(255,255,255);border-radius:0px">
                            
                                
                                
                                
                                <table width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:100%" name="Layout_5">
                                <tbody><tr>
                                    <td align="center" valign="top">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="background-color:rgb(255,255,255);padding-left:20px;padding-right:20px;border-collapse:separate;border-radius:0px;border-bottom:0px none rgb(200,200,200)">

                                                        <tbody><tr>
                                                            <td height="20" style="font-size:1px;line-height:0px">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="left">

                                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                    <tbody><tr>
                                                                        <th style="text-align:left;font-weight:normal;padding-right:0px" valign="top">

                                                                            <table border="0" valign="top" cellspacing="0" cellpadding="0" width="100%" align="left">

                                                                                <tbody><tr>
                                                                                    <td style="font-size:14px;font-family:Arial,Helvetica,sans-serif,sans-serif;color:#3c4858;line-height:21px"><div>'.$headerMessage.'</div>

                                                                                <div>&nbsp;</div>
                                                                                </td>
                                                                                </tr>
                                                                                </tbody></table>

                                                                            </th></tr>
                                                                </tbody></table></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" style="font-size:1px;line-height:0px">&nbsp;</td>
                                                        </tr>
                                                    </tbody></table>
                                    </td>
                                </tr>
                            </tbody></table>
                                
                                

                            </div></td>
                    </tr><tr>

                        <td align="center" valign="top">

                            <div style="background-color:rgb(255,255,255);border-radius:0px">
                                
                                
                                
                                
                            
                                <table width="100%" cellpadding="0" border="0" cellspacing="0" name="Layout_7" id="m_-2647993506786989335m_-1692576443445193334m_-2044590671222991195Layout_7"><tbody><tr>
                                    <td align="center" valign="top">
                                        <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="height:0px;background-color:rgb(255,255,255);border-radius:0px;border-collapse:separate;padding-left:20px;padding-right:20px"><tbody><tr>
                                                <td>

                                                    <table border="0" cellpadding="0" cellspacing="0" align="center" style="margin:auto">
                                                        <tbody><tr>

                                                            <th align="center" style="text-align:center;font-weight:normal">

                                                                <table border="0" cellspacing="0" cellpadding="0" align="center">

                                                                    <tbody><tr>
                                                                        <td height="10"></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td style="font-family:Arial,Helvetica,sans-serif;color:#3c4858;text-align:center">

                                                                            <span style="color:#3c4858"><strong><span style="font-size:24px">Order Summary</span></strong></span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="10"></td>
                                                                    </tr>
                                                                    </tbody></table>
                                                                </th></tr>
                                                    </tbody></table></td>
                                            </tr>

                                        </tbody></table>

                                    </td>
                                </tr>

                            </tbody></table>
                                
                                
                            
                        </div></td>
                    </tr><tr>

                        <td align="center" valign="top">

                            <div style="background-color:rgb(255,255,255);border-radius:0px">
                            
                                
                                
                                
                                <table width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:100%" name="Layout_6">
                                <tbody><tr>
                                    <td align="center" valign="top">
                                        
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="background-color:rgb(255,255,255);padding-left:20px;padding-right:20px;border-collapse:separate;border-radius:0px;border-bottom:0px none rgb(200,200,200)">

                                                        <tbody><tr>
                                                            <td height="20" style="font-size:1px;line-height:0px">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="left">

                                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                    <tbody><tr>
                                                                        <th style="text-align:left;font-weight:normal;padding-right:0px" valign="top">

                                                                            <table border="0" valign="top" cellspacing="0" cellpadding="0" width="100%" align="left">

                                                                                <tbody><tr>
                                                                                    <td style="font-size:14px;font-family:Arial,Helvetica,sans-serif,sans-serif;color:#3c4858;line-height:21px"><div><strong><span style="background-color:transparent">Billed To:</span></strong></div>

                                                                                    <div>'.$userData->fname.' '.$userData->lname.'<br>
                                                                                    '.$orderData->street.', '.$orderData->city.', '.$orderData->state.' <br> '.$orderData->zipcode.', '.$orderData->country.'
                                                                                     <br>
                                                                                    <a href="'.$userData->email.'" target="_blank">'.$userData->email.'</a><br>
                                                                                    <br>
                                                                                    Order Number: CMOD0001'.$orderData->id.'<br>
                                                                                    Order Date: '.$dateis.'</div>

                                                                                    <div>&nbsp;</div>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody></table>

                                                                            </th></tr>
                                                                </tbody></table></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" style="font-size:1px;line-height:0px">&nbsp;</td>
                                                        </tr>
                                                    </tbody></table>
                                    </td>
                                </tr>
                            </tbody></table>
                                
                                

                            </div></td>
                    </tr><tr>

                        <td align="center" valign="top">

                            <div style="background-color:rgb(218,220,224);border-radius:0px">
                            
                                
                                
                                
                                <table width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:100%" name="Layout_8">
                                <tbody><tr>
                                    <td align="center" valign="top">
                                       
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#dadce0" style="background-color:rgb(218,220,224);padding-left:20px;padding-right:20px;border-collapse:separate;border-radius:0px;border-bottom:0px none rgb(200,200,200)">

                                                        <tbody><tr>
                                                            <td height="20" style="font-size:1px;line-height:0px">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="left">

                                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                    <tbody><tr>
                                                                        <th style="text-align:left;font-weight:normal;padding-right:0px" valign="top">

                                                                            <table border="0" valign="top" cellspacing="0" cellpadding="0" width="100%" align="left">

                                                                                <tbody><tr>
                                                                                    <td style="font-size:14px;font-family:Arial,Helvetica,sans-serif,sans-serif;color:#3c4858;line-height:21px"><div>Licence Key: <strong>'.$licenceKey.'</strong></div>

                                                                                    <div>Product: <strong>Ale-izba Driver Updater</strong>'.$autorenewal.'</div>

                                                                                    <div>Quantity: <strong>01</strong></div>

                                                                                    <div dir="rtl" style="text-align:right">&nbsp;Sub-total: $'.$orderData->amount.'</div>

                                                                                    <div dir="rtl" style="text-align:right">&nbsp;<span style="background-color:transparent">Tax: $0.00</span>

                                                                                    <div><strong>Total: $'.$orderData->amount.'</strong></div>
                                                                                    </div>

                                                                                    <div>&nbsp;</div>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody></table>

                                                                            </th></tr>
                                                                </tbody></table></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" style="font-size:1px;line-height:0px">&nbsp;</td>
                                                        </tr>
                                                    </tbody></table>
                                    </td>
                                </tr>
                            </tbody></table>
                                
                                

                            </div></td>
                    </tr><tr>

                        <td align="center" valign="top">

                          
                            </td>
                    </tr><tr>

                        <td align="center" valign="top">

                            <div style="background-color:rgb(255,255,255);border-radius:0px">
                                
                                
                                
                                
                                <table width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:590px" name="Layout_9" id="m_-2647993506786989335m_-1692576443445193334m_-2044590671222991195Layout_9">
                                <tbody><tr>
                                    <td align="center" valign="top" style="min-width:590px">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:rgb(255,255,255);border-radius:0px;padding-left:20px;padding-right:20px;border-collapse:separate">
                                            <tbody><tr>
                                                <td height="20" style="font-size:1px;line-height:0px">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td valign="top" align="left">

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                        <tbody><tr>
                                                            <th valign="top">

                                                                <table border="0" valign="top" cellspacing="0" cellpadding="0" width="550" align="center">

                                                                    <tbody><tr>
                                                                        <td valign="top">
                                                                            <table cellpadding="0" border="0" align="center" cellspacing="0" style="margin:auto;border-collapse:separate">
                                                                                <tbody><tr>
                                                                                    <td width="auto" valign="middle" bgcolor="#0092ff" align="center" height="40" style="font-size:18px;font-family:Arial,Helvetica,sans-serif;color:#ffffff;font-weight:normal;padding-left:20px;padding-right:20px;vertical-align:middle;background-color:#0092ff;border-radius:4px;border-top:0px None #000;border-right:0px None #000;border-bottom:0px None #000;border-left:0px None #000">
                                                                                        <span style="color:#ffffff;font-weight:normal">
                                                                                                <a href="https://Ale-izba.com/driver-installation-instruction" style="text-decoration:none;color:#ffffff;font-weight:normal"><strong>Download&nbsp;Computeriods Driver Updater</strong></a>
                                                                                            </span>
                                                                                    </td>
                                                                                </tr></tbody></table>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody></table>
                                                                </th>
                                                        </tr>
                                                    </tbody></table></td>
                                            </tr>
                                            <tr>
                                                <td height="20" style="font-size:1px;line-height:0px">&nbsp;</td>
                                            </tr>
                                        </tbody></table>

                                    </td>
                                </tr>
                            </tbody></table>
                            
                                
                                
                                
                            </div></td>
                    </tr><tr>

                        <td align="center" valign="top">

                            <div style="background-color:rgb(249,250,252);border-radius:0px">
                            
                                
                                
                                
                                <table width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:100%" name="Layout_10">
                                <tbody><tr>
                                    <td align="center" valign="top">
                                       
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#f9fafc" style="background-color:#fff;padding-left:20px;padding-right:20px;border-collapse:separate;border-radius:0px;border-bottom:0px none rgb(200,200,200)">

                                                        <tbody><tr>
                                                            <td height="5" style="font-size:1px;line-height:0px">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="left">
                                                                <!-- support Number-->
                                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td align="center" style="font-family:Arial,Helvetica,sans-serif,sans-serif;" ><b> Support Number :  +1-888-357-5222</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td height="5" style="font-size:1px;line-height:0px">&nbsp;</td>
                                                                  </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!--// support Number-->
                                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                    <tbody><tr>
                                                                        <th style="text-align:left;font-weight:normal;padding-right:0px" valign="top">

                                                                            <table border="0" valign="top" cellspacing="0" cellpadding="0" width="100%" align="left">

                                                                                <tbody><tr>
                                                                                    <td style="font-size:14px;font-family:Arial,Helvetica,sans-serif,sans-serif;color:#3c4858;line-height:21px"><div style="text-align:center"><a href="https://Ale-izba.com/support"> Support </a> |  <a href="https://Ale-izba.com/driver-installation-instruction"> Installation Instructions</a> | <a href="https://Ale-izba.com/eula"> EULA</a> | <a href="https://Ale-izba.com/privacy-policy">Privacy Policy</a></div>
                </td>
                                                                                </tr>
                                                                                </tbody></table>

                                                                            </th></tr>
                                                                </tbody></table></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" style="font-size:1px;line-height:0px">&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </td>
                </tr>
                </tbody>
                </table>' ;
          return $htmlContent;
        }



        function sendProductKeyMailTemplate($orderData, $userData, $productData,$productKeyData){
           $i = 1;
           $productTable = '';
           foreach ($productKeyData as $v){
           $productTable .= '<tr bgcolor="#fff" ><td style="padding: 3px" ><b>'.$i.'.</b>&nbsp;&nbsp;&nbsp; '.$v->productKey.'</td></tr>';
            $i++;
            }
          $htmlContent = '
            <table width="100%" style="background:#ececec;border-collapse:collapse">
              <tbody>
              <tr>
              <td valign="top">
                <center>
                  <table bgcolor="#fff" width="700">
                  <tbody>
                  <tr>
                  <td valign"top">
                  <center>
                  <table cellspacing="0" style="background:#f0f2f1;border-collapse:collapse;padding:30px" width="600">
                    <tbody>
                      <tr style="background-color: #fff;">
                          <td align="center" style="padding-bottom: 5px;padding-top: 20px;" >
                            <img src="'.base_url("assets/images/computeriods-logo-22.png").'" width="300" />
                          </td>
                      </tr>
                      <tr style="background-color: #fff;">
                          <td align="" style="padding: 16px 0px;" >
                            <p style="font-size: 18px;color: #272626;">Hi <b>'.$userData->fname.' '.$userData->lname.'</b>, Your Ale-izba Application is Activated. You can continue to use Ale-izba all feature. </p>
                          </td>
                      </tr>
                    </tbody>
                  </table>
                  <table cellspacing="0" style="background:#f0f2f1;border-collapse:collapse;padding:30px" width="600">
                      <tbody>
                     
                      <tr style="background-color: #fff;border-bottom: 2px solid #cecbcb;">    
                          <th align="left" style="padding: 9px 0px;font-size: 20px;color: #272626;">Ale-izba Product Key: </th><td align="right" style="padding: 9px 0px;font-size: 20px;color: #272626;"></td>
                      </tr>
                    </tbody>
                    </table>

                    <table cellspacing="0" style="background:#f0f2f1;border-collapse:collapse;" width="600">
                    <tbody>
                      
                          '.$productTable.'
                    </tbody>
                    </table>  
                 </center>
               <td>
               </tr>
               </tbody>
               </table>
             </center>
             </td>
             </tr>
             </tbody>
             </table> 
          </body>
          </html>';
          return $htmlContent;
        }




        // trail download link share 
        // =======================================================================================================================  
        function trialdownloadlink(){
            $htmlContent = '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

              <!-- START HEADER/BANNER -->

                  <tbody><tr>
                    <td align="center">
                      <table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border-left: 1px solid #dbd9d9;border-right: 1px solid #dbd9d9;border-top: 1px solid #dbd9d9; background-color: #dbd9d9;">
                        <tbody><tr>
                          <td align="center" valign="top"  style="background-size:cover; background-position:top;height=" 400""="">
                            <table class="col-600" width="600" height="100" border="0" align="center" cellpadding="0" cellspacing="0">

                              <tbody><tr>
                                <td height="40"></td>
                              </tr>


                              <tr>
                                <td align="center" style="line-height: 0px;">
                                  <img style="display:block; line-height:0px; font-size:0px; border:0px;" src="https://Ale-izba.com/assets/images/computeriods-logo-22.png" width="300"  alt="logo">
                                </td>
                              </tr>

                              <tr>
                                <td height="50"></td>
                              </tr>
                            </tbody></table>
                          </td>
                        </tr>
                      </tbody></table>
                    </td>
                  </tr>


              <!-- END HEADER/BANNER -->


              <!-- START 3 BOX SHOWCASE -->

                  <tr>
                    <td align="center">
                      <table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:20px; margin-right:20px; border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9;padding: 0 20px">
                        <tbody><tr>
                          <td height="35"></td>
                        </tr>

                        <tr>
                          <td align="left" style="font-family: Lato, sans-serif; font-size:14px; color:#333; line-height:24px; font-weight: 300;">
                            Thank you for downloading Ale-izba Driver Updater software.
                          </td>
                        </tr>
                        <tr>
                          <td height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" style="font-family: Lato, sans-serif; font-size:14px; color:#333; line-height:24px; font-weight: 300;">
                            Please click <b style="font-weight:600"> <a href="https://Ale-izba.com/trial-driver-download">HERE</a></b> to download the software. You may also click on the following link to download the software.
                          </td>
                        </tr>

                        <tr>
                          <td height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" style="font-family: Lato, sans-serif; font-size:14px; color:#333; line-height:24px; font-weight: 300;">
                            <a href="https://Ale-izba.com/trial-driver-download">https://Ale-izba.com/trial-driver-download?token=8999977djfkdfjk-fddjfkikjeijhekijeru-djfdf==myernmmy?lesterekjjkdfdkf=grennchna&pmmkfhdf=333333</a>
                          </td>
                        </tr>

                         <tr>
                          <td height="30"></td>
                        </tr>

                        <tr>
                          <td align="left" style="font-family: Lato, sans-serif; font-size:14px; color:#333; line-height:24px; font-weight: 300;">
                            Thank you
                          </td>
                        </tr>
                        <tr>
                          <td align="left" style="font-family: Lato, sans-serif; font-size:14px; color:#333; line-height:24px; font-weight: 300;">
                            Team Ale-izba
                          </td>
                        </tr>
                        <tr>
                          <td height="30"></td>
                        </tr>
                        

                        



                      </tbody></table>
                    </td>
                  </tr>

                  

                    <tr>
                        <td height="5"></td>
                  </tr>


              <!-- END 3 BOX SHOWCASE -->


              <!-- START AWESOME TITLE -->

                  <tr>
                    <td align="center">
                      <table align="center" class="col-600" width="600" border="0" cellspacing="0" cellpadding="0" >
                        <tbody><tr>
                          <td align="center" bgcolor="#dbd9d9">
                            <table class="col-600" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="padding: 0 20px">
                              <tbody><tr>
                                <td height="33"></td>
                              </tr>
                              <tr>
                                <td align="center" style="font-family: Lato, sans-serif; font-size:14px; color:#333; line-height:24px; font-weight: 300;">
                                  <b style="font-size: 16px;">Support Number : +1-888-357-5222</b>
                                </td>
                              </tr> 
                              <tr>
                                <td height="10"></td>
                              </tr>
                              <tr>
                                <td align="center" style="font-family: Lato, sans-serif; font-size:14px; color:#333; line-height:24px; font-weight: 300;">
                                  <a href="https://Ale-izba.com/support">Support</a> &nbsp; 
                                  <a href="https://Ale-izba.com/driver-installation-instruction">Installation Instruction</a>&nbsp;
                                  <a href="https://Ale-izba.com/eula">EULA</a>&nbsp;
                                  <a href="https://Ale-izba.com/privacy-policy">Privacy Policy</a>&nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td height="20"></td>
                              </tr> 
                              
                            </tbody></table>
                          </td>
                        </tr>
                      </tbody></table>
                    </td>
                  </tr>


              <!-- END AWESOME TITLE -->







              <!-- END WHAT WE DO -->
              </tbody></table>';
            return $htmlContent;
        }


?>