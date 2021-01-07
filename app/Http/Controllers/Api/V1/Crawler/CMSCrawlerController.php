<?php

namespace App\Http\Controllers\Api\V1\Crawler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kbih;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Validator;
use Carbon\Carbon;
use Auth;
use DB;
use App\User;
use App\Notifications\FirebasePushNotif;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Faq;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;
use GuzzleHttp\Client as GuzzleClient;


class CMSCrawlerController extends Controller{
    public function login(Request $request){
  //   	$client 		= new Client(HttpClient::create(['timeout' => 60]));
  //   	// $client->getClient()->setDefaultOption('config/curl/'.CURLOPT_SSL_VERIFYHOST, FALSE);
  //   	// $client->getClient()->setDefaultOption('config/curl/'.CURLOPT_SSL_VERIFYPEER, FALSE);

  //   	// CMS LOGIN
  //   	$client 		= new Client(HttpClient::create(['timeout' => 60]));
  //       $crawler 		= $client->request('GET', 'https://cms.megasyariah.co.id/company/auth/login.xhtml');
        // $credential 	= [
        // 	'loginForm:companyId' 	=> 'DGE01', 
        // 	'loginForm:username' 		=> 'Sysadmin1',
        // 	'loginForm:password' 		=> 'Myduma21',
        // ];
		// $form 			= $crawler->selectButton('LOGIN')->form();
		// $crawler 		= $client->submit($form, $credential);
		// dump($crawler);
		// return $crawler->html();

  //   	$client 		= new Client(HttpClient::create(['timeout' => 60]));
  //       $credential 	= [
  //       	'email' 		=> 'admin@myduma.id', 
  //       	'password' 		=> 'bismillah',
  //       ];
		// $crawler 		= $client->request('GET', 'http://198.167.141.141/login');
		// $form 			= $crawler->selectButton('Sign In')->form();
		// $crawler 		= $client->submit($form, $credential);
		// return $crawler->html();


		// $browser 		= new HttpBrowser(HttpClient::create());
		// $credential 	= [
  //       	'email' 		=> 'admin@myduma.id', 
  //       	'password' 		=> 'bismillah',
  //       ];
		// $browser->request('GET', 'http://198.167.141.141/login');
		// $first = $browser->getCrawler()->filter('body')->first()->text();
		// $form 			= $browser->getCrawler()->selectButton('Sign In')->form();
		// $browser->submit($form,$credential);
		// $after = $browser->getCrawler()->filter('body')->first()->text();
		// return $first.'  -  '.$after;
		// return $browser->getCrawler()->html();

		$browser 		= new HttpBrowser(HttpClient::create([
			'verify_host' => false,
			'verify_peer' => false
		]));
		$credential 	= [
        	'loginForm:companyId' 	=> 'DGE01', 
        	// 'loginForm:username' 		=> 'Sysadmin1',
        	// 'loginForm:password' 		=> 'Myduma21',
        	'loginForm:j_idt34' 		=> 'loginForm:j_idt34',
        	'loginForm:encryptUsername' 		=> 'U2FsdGVkX18uKAmmhwtml/we6/I9phhO/6ulaEN9GSM=',
        	'loginForm:encryptPassword' 		=> 'U2FsdGVkX18fiHZJ4u9jdkWdJB/+eVAjj0aBI8DsVpc=',
        ];
		$browser->request('GET', 'https://cms.megasyariah.co.id/company/auth/login.xhtml');
		// dump($browser);
		$form 			= $browser->getCrawler()->selectButton('LOGIN')->form();
		$browser->submit($form,$credential);
		dump($browser);
		// return $browser->getCrawler()->html();
		// dump($browser->getCrawler()->filter('.mega-left-info')->first());
		// return $browser->getCrawler()->filter('.company-greeting')->first();
		// $browser->filter('.company-greeting')->
		// dump($browser);
		// return $browser->getCrawler()->html();
    }
}
