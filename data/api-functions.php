<?php
//////authenticate with ca.crt and use our service accounts api key //////////////////////
//////   ONLY NEEDED IF NOT USING KUBES REVERS PROXY /////////////////////////////////////

//$TOKEN = file_get_contents('apikey.txt');
//$CA = 'ca.crt';
////set ca.crt
//curl_setopt($curl, CURLOPT_CAINFO, '/tmp/ca.crt' );

/////TOKEN WILL NEED TO BE INSERTED TO HEADER AS: Authorization: Bearer

////Optional INSECURE MODE if using https
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

//////////////////////////////////////////////////////////////////////////////////////////
function create_namespace()
{
	//// kubectl proxy --port 8001 --address=192.168.49.1 --accept-hosts=^* ////
	//// api url (minikubes ip)
	$url = 'http://192.168.49.1:8001/api/v1/namespaces';

	//get variables from login (will later be done using session variables)
	//$user = $_POST["username"];
	$user=$_SESSION['gatekeeper'];

	//// yaml for the creation of users namespace
	$data ='kind: Namespace
apiVersion: v1
metadata:
  name: '.$user;

	////initialize a new cURL session
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	//set headers for API authentication and Content-Type
	curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/yaml']);

	////execute CURL request with specified options
	$response = curl_exec($curl);

	////close curl session
	curl_close($curl);
        create_deployment();
       // create_deployment();

}

function create_deployment()
{
	//// kubectl proxy --port 8001 --address=192.168.49.1 --accept-hosts=^* ////
	//// api url (minikubes ip)
	$url = 'http://192.168.49.1:8001/apis/apps/v1/namespaces/'.$_SESSION['gatekeeper'].'/deployments';

	$deployment = $_GET['image'];
	//// data to be posted to kube api (must be json or yaml)
	$data = file_get_contents($deployment.'.yaml');

	////initialize a new cURL session
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	//set headers for API authentication and Content-Type
	curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/yaml']);

	////execute CURL request with specified options
	$response = curl_exec($curl);

	//stop session
	curl_close($curl);

	//checks to see if current namespace exists
	$error = "NotFound";  
	$chr = strchr($response , $error);
	if($chr == true)
	{
		create_namespace();
	}
	else
	{
		create_service();
	}
}

function create_service()
{
	//// kubectl proxy --port 8001 --address=192.168.49.1 --accept-hosts=^* ////
        //// api url (minikubes ip)
	$url = 'http://192.168.49.1:8001/api/v1/namespaces/'.$_SESSION['gatekeeper'].'/services';
	
	$deployment = $_GET['image'];

	//// data to be posted to kube api (must be json or yaml)
	$data = file_get_contents($deployment.'-svc.yaml'); 

	////initialize a new cURL session
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 	
	//set headers for API authentication and Content-Type
	curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/yaml']);

	////execute CURL request with specified options
	$response = curl_exec($curl);
        
	//close session
	curl_close($curl); 
}

function get_services()
{
	//curls the api to get data about the services for deployments (used to show users endpoints)
	$url = 'http://192.168.49.1:8001/api/v1/namespaces/'.$_SESSION['gatekeeper'].'/services';
	////initialize a new cURL session
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	$response_data=json_decode($response, true);
        curl_close($curl);

	// second curl gets data about replicasets, specifically to get the replica count for rescaling to pause deployments
	$url2 = 'http://192.168.49.1:8001/apis/apps/v1/namespaces/'.$_SESSION['gatekeeper'].'/replicasets';
	$curl2 = curl_init($url2);
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
	$response2 = curl_exec($curl2);
        curl_close($curl2);
	
	$response_data2=json_decode($response2, true);
	

	echo "<table>";
	echo "<tr>";
		echo "<th>Container</th>";
		echo "<th>Endpoint</th>";
		echo "<th>Start/Stop</th>";
		echo "<th>Delete</th>";
	echo "</tr>";	
	//loops the response contents displaying to the user
	$i = 0;			
	while ($i < count($response_data['items']))
	{
		echo "<tr>";
		echo "<td>";
		echo $response_data['items'][$i]['metadata']['name'];
		echo "</td>";
		echo "<td>";
		echo "192.168.49.2:".$response_data['items'][$i]['spec']['ports']['0']['nodePort'];
		echo "</td>";
		

		//gets node address,  status, and service name
		$node = "https://192.168.49.2:".$response_data['items'][$i]['spec']['ports']['0']['nodePort'];
		$status = $response_data2['items'][$i]['status']['replicas'];
	 	$service = $response_data['items'][$i]['metadata']['name'];
		if($status==0) {
			//if replica sets are set to 0 the option to start up the lab instance will show
			if(isset($_POST['start'])) {
				pause_deployment($i, 1);
			}
			echo "<td>";
			echo "<form method='post'>";
                     	echo "<input type='submit' name='start' value='Start'/>";
			echo "</form>";
			echo "</td>";
			
		}
		else{
			//if replica sets are set to 1 the option to pause the lab instance will show
			if(isset($_POST['pause'])) {
				pause_deployment($i, 0);
			}
			//shows node when started
			echo "<td>";		
			echo "<form method='post'>";
                        echo "<input type='submit' name='pause' value='Stop'/>";
			echo "</form>";
			echo "</td>";


		}	
		$i++;
		
		if(isset($_POST['remove'])) {
			//service and deployment names are the same for each environment
			delete_deployment($service);
		}		
		//remove button
		echo "<td>";
	        echo "<form method='post'>";
        	echo "<input type='submit' name='remove' value='Remove'/>";
        	echo "</form>";
        	echo "</td>";
        	echo "</tr>";

	}
	//displays shell-in-a-box window for terminal access
	echo "<iframe style='float: right; border: 5px solid #333; margin-top: 20px; padding:10px' src='$node' width=50%' height='50%'/>";
	echo "</table>";

}

function get_services_lab($lab)
{

        $url = 'http://192.168.49.1:8001/api/v1/namespaces/'.$lab.'/services';
        ////initialize a new cURL session
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


        ////execute CURL request with specified options
        $response = curl_exec($curl);
        $response_data=json_decode($response, true);
        $i = 0;

        while ($i < count($response_data['items']))
        {
                echo "</br>";
                echo "container: ".$response_data['items'][$i]['metadata']['name'];
                echo "</br>";
                echo "Endpoint: https://192.168.49.2:".$response_data['items'][$i]['spec']['ports']['0']['nodePort'];
                echo "</br>";
                $i++;
        }
        //close session
        curl_close($curl);

}

function pause_deployment($item, $n)
{
	// this function scales down the replica set of the specified lab environment to 0
	
	//curl1 gets replica set names for curl2
	$url1 = 'http://192.168.49.1:8001/apis/apps/v1/namespaces/'.$_SESSION['gatekeeper'].'/deployments';
	$curl1 = curl_init($url1);
	curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl1);
        $response_data=json_decode($response, true);
        print_r($resposne_data);
        $deployment = $response_data['items'][$item]['metadata']['name'];
 
	//curl2 scales down the replicasets of the specified item
	$url2 = 'http://192.168.49.1:8001/apis/apps/v1/namespaces/'.$_SESSION['gatekeeper'].'/deployments/'.$deployment;
	$data = '{"spec":{"replicas":'.$n.'}}';
	
	 
	$curl2 = curl_init($url2);
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, 'PATCH');
	curl_setopt($curl2, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl2, CURLOPT_HTTPHEADER, ['Content-Type: application/strategic-merge-patch+json']);
	$response2 = curl_exec($curl2);
	
	//close session
        curl_close($curl1);
	curl_close($curl2);

	echo '<META HTTP-EQUIV=Refresh CONTENT="1">';
}

function delete_deployment($name)
{
	//this function deletes both the deployment and its service 

	//curl1 is to delete the deployment
	$url1 = 'http://192.168.49.1:8001/apis/apps/v1/namespace/'.$_SESSION['gatekeeper'].'/deployments/'.$name;
	$curl1 = curl_init($url1);
	curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl1, CURLOPT_CUSTOMREQUEST, 'DELETE');
	$response1 = curl_exec($curl1);


	//curl 2 deletes the deployments service
	$url2 = 'http://192.168.49.1:8001/api/v1/namespaces/'.$_SESSION['gatekeepr'].'/services/'.$name;
	$curl2 = curl_init($url2);
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, 'DELETE');
	$response2 = curl_exec($curl2);

	echo $respone1;
	echo $response2;
	
	//close session
        curl_close($curl1);
        curl_close($curl2);
}


?>
