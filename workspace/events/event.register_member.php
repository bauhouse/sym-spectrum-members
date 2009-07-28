<?php

	require_once(TOOLKIT . '/class.event.php');
	
	Class eventregister_member extends Event{
		
		const ROOTELEMENT = 'register-member';
		
		public $eParamFILTERS = array(
			'send-email'
		);
			
		public static function about(){
			return array(
					 'name' => 'Register Member',
					 'author' => array(
							'name' => 'Stephen Bau',
							'website' => 'http://home/sym/spectrum-members',
							'email' => 'stephen@domain7.com'),
					 'version' => '1.0',
					 'release-date' => '2009-07-27T20:12:53+00:00',
					 'trigger-condition' => 'action[register-member]');	
		}

		public static function getSource(){
			return '7';
		}

		public static function allowEditorToParse(){
			return true;
		}

		public static function documentation(){
			return '
        <h3>Success and Failure XML Examples</h3>
        <p>When saved successfully, the following XML will be returned:</p>
        <pre class="XML"><code>&lt;register-member result="success" type="create | edit">
  &lt;message>Entry [created | edited] successfully.&lt;/message>
&lt;/register-member></code></pre>
        <p>When an error occurs during saving, due to either missing or invalid fields, the following XML will be returned:</p>
        <pre class="XML"><code>&lt;register-member result="error">
  &lt;message>Entry encountered errors when saving.&lt;/message>
  &lt;field-name type="invalid | missing" />
  ...
&lt;/register-member></code></pre>
        <p>The following is an example of what is returned if any filters fail:</p>
        <pre class="XML"><code>&lt;register-member result="error">
  &lt;message>Entry encountered errors when saving.&lt;/message>
  &lt;filter name="admin-only" status="failed" />
  &lt;filter name="send-email" status="failed">Recipient username was invalid&lt;/filter>
  ...
&lt;/register-member></code></pre>
        <h3>Example Front-end Form Markup</h3>
        <p>This is an example of the form markup you can use on your frontend:</p>
        <pre class="XML"><code>&lt;form method="post" action="" enctype="multipart/form-data">
  &lt;input name="MAX_FILE_SIZE" type="hidden" value="5242880" />
  &lt;label>Full Name
    &lt;input name="fields[full-name]" type="text" />
  &lt;/label>
  &lt;label>First Name
    &lt;input name="fields[first-name]" type="text" />
  &lt;/label>
  &lt;label>Last Name
    &lt;input name="fields[last-name]" type="text" />
  &lt;/label>
  &lt;div class="group">
    &lt;label>Username
      &lt;input name="fields[member][username]" type="text" />
    &lt;/label>
    &lt;label>Password
      &lt;input name="fields[member][password]" type="password" />
    &lt;/label>
  &lt;/div>
  &lt;label>Role
    &lt;select name="fields[role]">
      &lt;option value="1">Guest&lt;/option>
    &lt;/select>
  &lt;/label>
  &lt;label>Email
    &lt;input name="fields[email]" type="text" />
  &lt;/label>
  &lt;input name="action[register-member]" type="submit" value="Submit" />
&lt;/form></code></pre>
        <p>To edit an existing entry, include the entry ID value of the entry in the form. This is best as a hidden field like so:</p>
        <pre class="XML"><code>&lt;input name="id" type="hidden" value="23" /></code></pre>
        <p>To redirect to a different location upon a successful save, include the redirect location in the form. This is best as a hidden field like so, where the value is the URL to redirect to:</p>
        <pre class="XML"><code>&lt;input name="redirect" type="hidden" value="http://home/sym/spectrum-members/success/" /></code></pre>
        <h3>Send Email Filter</h3>
        <p>The send email filter, upon the event successfully saving the entry, takes input from the form and send an email to the desired recipient. <b>This filter currently does not work with the "Allow Multiple" option.</b> The following are the recognised fields:</p>
        <pre class="XML"><code>send-email[from]
send-email[subject] // Optional
send-email[body]
send-email[recipient] // list of comma author usernames.</code></pre>
        <p>All of these fields can be set dynamically using the exact field name of another field in the form as shown below in the example form:</p>
        <pre class="XML"><code>&lt;form action="" method="post">
  &lt;fieldset>
    &lt;label>Name &lt;input type="text" name="fields[author]" value="" />&lt;/label>
    &lt;label>Email &lt;input type="text" name="fields[email]" value="" />&lt;/label>
    &lt;label>Message &lt;textarea name="fields[message]" rows="5" cols="21">&lt;/textarea>&lt;/label>
    &lt;input name="send-email[from]" value="fields[email]" type="hidden" />
    &lt;input name="send-email[subject]" value="You are being contacted" type="hidden" />
    &lt;input name="send-email[body]" value="fields[message]" type="hidden" />
    &lt;input name="send-email[recipient]" value="fred" type="hidden" />
    &lt;input id="submit" type="submit" name="action[save-contact-form]" value="Send" />
  &lt;/fieldset>
&lt;/form></code></pre>';
		}
		
		public function load(){			
			if(isset($_POST['action']['register-member'])) return $this->__trigger();
		}
		
		protected function __trigger(){
			include(TOOLKIT . '/events/event.section.php');
			return $result;
		}		

	}

