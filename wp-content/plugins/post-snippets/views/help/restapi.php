<h2><?php _e('REST API', 'post-snippets'); ?> (<em><?php _e('for developers', 'post-snippets'); ?></em>)</h2>



<p><?php _e('Post Snippets REST API endpoints allow you to create, update, delete and get the snippet.', 'post-snippets'); ?></p>

<p style="color:red"><?php _e('Note: If any endpoint field is empty then that request will not be registered.', 'post-snippets'); ?></p>
<p style="color:red"><?php _e('Note: If 2 endpoint fields are identical then no requests will be registered.', 'post-snippets'); ?></p>

<h3><?php _e('Post Snippets Enable:', 'post-snippets'); ?></h3>
<ul>
  <li><?php _e('Click on the checkbox to enable the post snippets REST API functionality.', 'post-snippets'); ?></li>
</ul>

<h3><?php _e('Post Snippets Token:', 'post-snippets'); ?></h3>
<ul>
  <li><?php _e('Click on the Generate Token button.', 'post-snippets'); ?></li>
  <li><?php _e('You will find 16 character generated token in the input field.', 'post-snippets'); ?></li>
  <li><?php _e('Each time you click on the generate token button, it will create a unique token.', 'post-snippets'); ?></li>
</ul>

<h3><?php _e('Create Snippet:', 'post-snippets'); ?></h3>
<p style="color:red"><?php _e('Note: Do not enter any special characters [!@#$%^&*_(=+-)] into the title.', 'post-snippets'); ?></p>
<ul>
  <li><?php _e('Enter the snippet title', 'post-snippets'); ?></li>
  <li><?php _e('After entering the snippet title and saving settings, you will see the REST API URI.', 'post-snippets'); ?></li>
  <li><?php _e('Use the following URI parameters to create a snippet', 'post-snippets'); ?>
  
    <ul>
      <li>{token} : (xxxxxxxxxxxxxxxx) 16 character generated token</li>
      <li>{snippet-title} : sample-snippet</li>
      <li>{vars}: use <strong>0</strong> for empty or enter comma separated values e.g: <strong>bob, rob, den</strong></li>
      <li>{shortcode}: <strong>1</strong> for enable or <strong>0</strong> for disable/empty </li>
      <li>{php} : <strong>1</strong> or <strong>0</strong></li>
      <li>{wptexturize} : <strong>1</strong> or <strong>0</strong></li>
      <li>{snippet-code}: write <strong>simple/plain</strong>  text, <strong>HTML, PHP</strong>  etc.</li>
      <li>{snippet-description}: lorem ipsum is simply dummy text</li>
    </ul>
  </li>
  <li><?php _e('Response result should look like this:', 'post-snippets'); ?>
    <ul>
        <li style="list-style-type: none;"><img src="<?php echo plugins_url('assets/img/help/create-snippet-success.png', \PostSnippets::FILE); ?>" /></li>
    </ul>
  </li>
</ul>

<h3><?php _e('Update Snippet:', 'post-snippets'); ?></h3>
<p style="color:red"><?php _e('Note: Do not enter any special characters [!@#$%^&*_(=+-)] into the title.', 'post-snippets'); ?></p>
<ul>
  <li><?php _e('Enter the snippet title', 'post-snippets'); ?></li>
  <li><?php _e('After entering the snippet title and saving settings, you will see the REST API URI.', 'post-snippets'); ?></li>
  <li><?php _e('Use the following URI parameters to update a snippet', 'post-snippets'); ?>
  
    <ul>
      <li>{token} : (xxxxxxxxxxxxxxxx) 16 character generated token</li>
      <li>{snippet-title} : sample-snippet (The title of snippet to update)</li>
      <li>{vars}: use <strong>0</strong> for empty or enter comma separated values e.g: <strong>bob, rob, den</strong></li>
      <li>{shortcode}: <strong>1</strong> for enable or <strong>0</strong> for disable/empty </li>
      <li>{php} : <strong>1</strong> or <strong>0</strong></li>
      <li>{wptexturize} : <strong>1</strong> or <strong>0</strong></li>
      <li>{snippet-code}: write <strong>simple/plain</strong>  text, <strong>HTML, PHP</strong>  etc.</li>
      <li>{snippet-description}: lorem ipsum is simply dummy text</li>
    </ul>
  </li>
  <li><?php _e('Response result should look like this:', 'post-snippets'); ?>
    <ul>
        <li style="list-style-type: none;"><img src="<?php echo plugins_url('assets/img/help/update-snippet-success.png', \PostSnippets::FILE); ?>" /></li>
    </ul>
  </li>
</ul>


<h3><?php _e('Get Particular Snippet:', 'post-snippets'); ?></h3>
<ul>
  <li><?php _e('Enter the snippet title', 'post-snippets'); ?></li>
  <li><?php _e('After entering the snippet title and saving settings, you will see the REST API URI.', 'post-snippets'); ?></li>
  <li><?php _e('Use the following URI parameters to get a particular snippet', 'post-snippets'); ?>
    <ul>
      <li>{token} : (xxxxxxxxxxxxxxxx) 16 character generated token</li>
      <li>{snippet-title} : sample-snippet (The title of snippet to get)</li>
    </ul>
  </li>
  <li><?php _e('Response result should look like this:', 'post-snippets'); ?>
    <ul>
        <li style="list-style-type: none;"><img src="<?php echo plugins_url('assets/img/help/get-a-snippet-success.png', \PostSnippets::FILE); ?>" /></li>
    </ul>
  </li>
</ul>

<h3><?php _e('Get all Snippets:', 'post-snippets'); ?></h3>
<ul>
  <li><?php _e('Enter the snippet title e.g: get-all-snippets', 'post-snippets'); ?></li>
  <li><?php _e('After entering the snippet title and saving settings, you will see the REST API URI.', 'post-snippets'); ?></li>
  <li><?php _e('Use the following URI parameters to get all snippets', 'post-snippets'); ?>
    <ul>
      <li>{token} : (xxxxxxxxxxxxxxxx) 16 character generated token</li>
    </ul>
  </li>
  <li><?php _e('Response result should look like this:', 'post-snippets'); ?>
    <ul>
        <li style="list-style-type: none;"><img src="<?php echo plugins_url('assets/img/help/get-all-snippets-success.png', \PostSnippets::FILE); ?>" /></li>
    </ul>
  </li>
</ul>

<h3><?php _e('Delete a particular snippet:', 'post-snippets'); ?></h3>
<ul>
  <li><?php _e('Enter the snippet title e.g: del-snippet', 'post-snippets'); ?></li>
  <li><?php _e('After entering the snippet title and saving settings, you will see the REST API URI.', 'post-snippets'); ?></li>
  <li><?php _e('Use the following URI parameters to delete a particular snippet', 'post-snippets'); ?>
    <ul>
      <li>{token} : (xxxxxxxxxxxxxxxx) 16 character generated token</li>
      <li>{snippet-title} : sample-snippet (The title of snippet to delete)</li>
    </ul>
  </li>
  <li><?php _e('Response result should look like this:', 'post-snippets'); ?>
    <ul>
        <li style="list-style-type: none;"><img src="<?php echo plugins_url('assets/img/help/delete-a-snippet-success.png', \PostSnippets::FILE); ?>" /></li>
    </ul>
  </li>
</ul>

<h3><?php _e('Delete multiple snippets:', 'post-snippets'); ?></h3>
<ul>
  <li><?php _e('Enter the snippet title e.g: del-multiple-snippets', 'post-snippets'); ?></li>
  <li><?php _e('After entering the snippet title and saving settings, you will see the REST API URI.', 'post-snippets'); ?></li>
  <li><?php _e('Use the following URI parameters to delete snippets', 'post-snippets'); ?>
    <ul>
      <li>{token} : (xxxxxxxxxxxxxxxx) 16 character generated token</li>
      <li>{snippet1-title}, {snippet2-title}, {snippet3-title}: first-snippet, second-snippet, third-snippet</li>
    </ul>
  </li>
  <li><?php _e('Response result should look like this:', 'post-snippets'); ?>
    <ul>
        <li style="list-style-type: none;"><img src="<?php echo plugins_url('assets/img/help/delete-multiple-snippets-success.png', \PostSnippets::FILE); ?>" /></li>
    </ul>
  </li>
</ul>