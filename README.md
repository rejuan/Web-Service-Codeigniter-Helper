Web-Service-Codeigniter-Helper
==============================

Here I am adding an example how you can use this helper.

1. First download this code from github. Then copy the webservice_helper.php and paste it to the "helpers" folder which is located in "application" folder.

2. Open the autoload.php from the "config" folder and add "webservice" as helper
	$autoload['helper'] = array('url','file','webservice');
	
3. Make a table called "user" which have 3 field 'id', 'email', 'password' and add some dummy data into the database

4. 	Add the following code to the controller

	<pre><code>
	public function signin(){
		$this->load->model('user_model');
		
		$email = $this->input->get_post('email');
		$password = $this->input->get_post('password');
		
		if($this->user_model->signin($email, $password))
			$msg = "successfully login";
		else
			$msg = "username and password doesn't match";
		
		
		$output = array(
							'msg' => $msg
						);
		
		jsonOutput($output);
	}
	</code></pre>
	
	
5. Make a model named "user_model" add the following code to the model
	
	<pre><code>
	function signin()
	{
		$query = $this->db->get_where('user', array('email' => $email, 'password' => $password));
		
		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}
	</code></pre>
