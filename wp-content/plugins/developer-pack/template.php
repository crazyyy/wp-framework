<?php if ( ! defined( 'ABSPATH'  )  ) exit; ?>

<div class="wrap">
	<h1>Developer Pack</h1>
	<div>
		<p>Welcome to Developer Pack. With this plugin you can view system information, download source code with advance options and live editing your website with a powerful code editor.</p>
		<div>
			<button id="phpinfo" class="button button-primary">PHP Info</button>
			<a href="https://codex.wordpress.org/WordPress_Coding_Standards" target="_blank" class="button">Coding standard</a>
			<a href="https://codex.wordpress.org/Plugin_API" target="_blank" class="button">Plugin API</a>
			<a href="https://codex.wordpress.org/Theme_Development" target="_blank" class="button">Theme Development</a>
			<a href="https://codex.wordpress.org/AJAX_in_Plugins" target="_blank" class="button">AJAX</a>
		</div>
	</div>
	<h2>Download source code</h2>
	<p>Zipped source code</p>
	<div class="notice notice-warning hidden" id="zipped-danger">
		<p>Don't forget to clean all the zipped source code after download or else it will lead to serious security bleach in your system!</p>
	</div>
	<table class="wp-list-table widefat fixed striped comments">
		<thead>
			<tr>
				<th class="manage-column">File</th>
				<th class="manage-column">Size</th>
				<th class="manage-column" width="100">Action</th>
			</tr>
		</thead>
		<tbody id="zipped">
		</tbody>
		<tbody id="no-zipped">
			<tr class="no-items"><td class="colspanchange" colspan="3">No zipped files found</td></tr>
		</tbody>
		<tfoot>
			<tr>
				<th></th>
				<th></th>
				<th scope="col">
					<a id="dearchive">Clean all</a>
				</th>
			</tr>
		</tfoot>
	</table>
	<div class="notice notice-success is-dismissible hidden" id="zipped-success">
		<p>File deleted successfully</p>
	</div>
	<p>Analize project</p>
	<button id="analize" class="button">Analize</button>
	<p id="analize-result"></p>
	<p>Download source code options</p>
	<div class="monaco">
		<div id="zip-options"></div>
	</div>
	<div>
		<button id="option-minimalist" class="button">Minimalist</button>
		<button id="option-sourcecode" class="button">Source Code</button>
		<button id="option-full" class="button">Full</button>
		<button id="action-zip" class="button button-primary">Create Zip</button>
	</div>
	<div class="hidden" id="created-zip-alert">
		<p>Zip file has been created successfully. Download it now: <a id="created-zip"></a></p>
	</div>
	<div>
		<h2>Code editing</h2>
		<p>
			Please open your <b>Browser Console</b> to see editor's action result. If you don't know how to open browser console, then google it. F12 will work on some browser!<br>
			We use Monaco for code editing. It's a free and opensource javascript text editor with advance feature from Microsoft.
		</p>
		<div class="monaco">
			<div id="diff"></div>
			<div id="tools">
				<div id="right">
					<input type="text" id="monaco-url">
					<button id="monaco-open">Open</button>
					<button id="monaco-save">Save</button>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	a {
		cursor: pointer;
	}
	.monaco {
		margin: 0;
		overflow: hidden;
		/* margin-left: -20px; */
		/* width: calc(100% + 40px); */
	}
	.monaco #zip-options {
		height: 200px;
	}
	.monaco #diff {
		height: calc(100vh - 62px);
	}
	.monaco #tools {
		height: 30px;
		width: 100%;
		background-color: #282c34;
	}
	.monaco #tools #left {
		float: left;
	}
	.monaco #tools #right {
		float: right;
	}
	.monaco #tools #left span {
		font-size: 10px;
		color: white;
		line-height: 30px;
		padding-left: 10px;
	}
	.monaco #tools #right > * {
		float: left;
	}
	.monaco #tools #monaco-url {
		margin: 0px;
	}
	.monaco #tools button {
		background-color: #2d89ef;
		color: white;
		padding: 0px 20px;
		height: 30px;
		line-height: 30px;
		border: none;
		cursor: pointer;
	}
	.monaco #tools button:hover {
		background-color: #2b5797;
	}
	.monaco #tools button:active {
		font-weight: bold;
	}
	.monaco #tools input[type=text] {
		font-size: 12px;
		background-color: #21252b;
		border: none;
		color: white;
		height: 30px;
		padding: 0px 10px;
		outline: none;
		width: 50vw;
	}
	.monaco #tools input[type=text]:focus {
		background-color: #ddd;
		color: #21252b;
	}
	.monaco #tools input[type=text].error {
		background-color: #fca1a2;
	}
	.monaco #tools input[type=text].warning {
		background-color: #fab604;
	}
	.monaco #tools input[type=text].success {
		background-color: #6cca6e;
	}
	.monaco #tools img {
		height: 20px;
		margin: 5px;
		float: right;
	}
</style>

<script>require = { paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.15.6/min/vs' } }</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.15.6/min/vs/loader.js"></script>
<script type="text/javascript" src="<?php echo $developerpack_dir; ?>/map.js"></script>
<script>
	(function ($) {
		function developerDispatch(data) {
			data.action = 'developerpack_' + data.action;
			return $.ajax({
				url: ajaxurl,
				method: 'POST',
				dataType: 'json',
				data
			});
		}
		function phpinfo() {
			var win = window.open();
			win.document.body.innerHTML = `<?php echo addslashes( $phpinfo ); ?>`;
		}
		function ConsoleBuffer() {
			this.data = '\n';
			this.log = function(data) {
				this.data += data + '\n';
			}
			this.end = function() {
				console.log(this.data);
				this.data = '\n';
			}
		}
		let buffer = new ConsoleBuffer();
		$('#phpinfo').click(phpinfo);
		function updateZipped() {
			$('#zipped').html('');
			developerDispatch({
				action: 'zipped'
			}).then(res => {
				window.resx = res;
				if (res.length > 0) {
					$('#zipped-danger').removeClass('hidden');
					$('#no-zipped').addClass('hidden');
					res.forEach(file =>
					$('<tr>').append(
						$('<td>').append(
							$('<a>', {
								href: '<?php echo $developerpack_dir; ?>/zip/' + file.name,
								text: file.name
							})
						),
						$('<td>' + file.size + '</td>'),
						$('<td>').append(
							$('<a />', {
								href: '#',
								class: 'dearchive-button',
								text: 'Delete',
								click: function() {
									developerDispatch({
										action: 'delete',
										file: file.path
									}).then(res => {
										$('#zipped-success').removeClass('hidden');
										updateZipped();
									});
								}
							})
						)
					).appendTo('#zipped'))
				} else {
					$('#zipped-danger').addClass('hidden');
					$('#no-zipped').removeClass('hidden');
				}
			});
		}
		updateZipped();
		$('#dearchive').click(() => {
			$('.dearchive-button').click();
		});
		$('#analize').click(() => {
			$(this).attr('disabled', 'disabled');
			developerDispatch({
				action: 'analize'
			}).then(res => $('#analize-result').text(JSON.stringify(res)));
			$(this).removeAttr('disabled');
		});
		function updateOptions(options) {
			jsonEditor.setValue(JSON.stringify(options, true, 4));
		}
		function minimalist() {
			updateOptions({
				action: "zip",
				output: "minimalist.zip",
				rule: "include",
				files: [
					"/<?php echo $theme_dir; ?>",
					"/<?php echo $child_theme_dir; ?>",
					"/wp-config.php"
				]
			});
		}
		function sourcecode() {
			updateOptions({
				action: "zip",
				output: "sourcecode.zip",
				rule: "exclude",
				files: [
					"/wp-admin",
					"/wp-includes",
					"/wp-content/backup-db",
					"/wp-content/backups",
					"/wp-content/blogs.dir",
					"/wp-content/cache",
					"/wp-content/upgrade",
					"/wp-content/uploads",
					"/wp-content/mu-plugins",
					".zip",
					".rar",
					".jpg",
					".png",
					".gif",
					".mp3",
					".mp4"
				]
			});
		}
		function full() {
			updateOptions({
				action: "zip",
				output: "full.zip",
				rule: "exclude",
				files: [
					"/.keep"
				],
				maxsize: 10000000,
				timeout: 300
			});
		}
		$('#option-minimalist').click(minimalist);
		$('#option-sourcecode').click(sourcecode);
		$('#option-full').click(full);
		function createZip() {
			$(this).attr('disabled', 'disabled');
			let options = JSON.parse(jsonEditor.getValue());
			developerDispatch(options).then(res => {
				if (res.status === 200) {
					updateZipped();
					$('#created-zip').attr('href', '<?php echo $developerpack_dir; ?>/zip/' + res.output);
					$('#created-zip').text(res.output);
					$('#created-zip-alert').removeClass('hidden');
					$('#created-zip-alert').addClass('notice notice-success');
				} else {
					alert(res.message);
				}
				$(this).removeAttr('disabled')
			}).fail(res => {
				alert("Something went wrong. Open console to view error");
				console.log(res);
				$(this).removeAttr('disabled')
			});
		}
		$('#action-zip').click(createZip);
		require(['vs/editor/editor.main'], function (main) {
			var originalModel = monaco.editor.createModel('');
			var modifiedModel = monaco.editor.createModel('');

			jsonEditor = monaco.editor.create(document.getElementById('zip-options'), {
				language: 'json',
				minimap: {
					enabled: false
				}
			});
			minimalist();

			diffEditor = monaco.editor.createDiffEditor(document.getElementById('diff'), {
				enableSplitViewResizing: true,
				language: 'javascript'
			});
			diffEditor.setModel({
			original: originalModel,
				modified: modifiedModel
			});

			window.addEventListener('resize', function () {
				diffEditor.layout();
			});
		});
		function extension(filename) {
			var re = /(?:\.([^.]+))?$/;
			return re.exec(filename)[1];
		}
		file = '';
		function monacoOpen(setModified = true) {
			file = $('#monaco-url').val();
			developerDispatch({
				action: 'open',
				file
			}).then(data => {
				if (data.status == 200) {
					$('#monaco-url').attr('class', '');
					diffEditor.getOriginalEditor().setValue(data.content);
					if (setModified) {
						diffEditor.getModifiedEditor().setValue(data.content);
					}
				} else if (data.status == 204) {
					$('#monaco-url').attr('class', 'warning');
					diffEditor.getOriginalEditor().setValue('');
				} else {
					$('#monaco-url').attr('class', 'error');
					diffEditor.getOriginalEditor().setValue('');
				}
				var l = language[extension(file)];
				console.clear();
				monaco.editor.setModelLanguage(diffEditor.getOriginalEditor().getModel(), l);
				monaco.editor.setModelLanguage(diffEditor.getModifiedEditor().getModel(), l);
				buffer.log('Available access: ');
				data.ls.forEach(e => buffer.log(e));
				buffer.log('Current directory: ' + data.pwd);
				buffer.log('Message: ' + data.message);
				buffer.end();
			});
		}
		function monacoSave() {
			$('#monaco-url').value = file;
			var content = diffEditor.getModifiedEditor().getValue();
			if (content == '') {
				var option = window.prompt('You are about to save a file with blank content. Type "delete" if you want to delete the file, or "save" if you really want to save the file "' + file + '"?');
				if (option !== 'save') {
					if (option === 'delete') {
						developerDispatch({
							action: 'delete',
							file
						}).then(data => {
							monacoOpen(false);
							alert(data.message);
						});
					}
					return;
				}
			}
			var confirm = window.confirm('Are you sure you want to make change to file "' + file + '"?');
			if (!confirm) {
				return;
			}
			developerDispatch({
				action: 'save',
				file,
				content
			}).then(data => {
			if (data.status == 200) {
				$('#monaco-url').attr('class', 'success');
				monacoOpen(false);
				alert(data.message);
			} else {
				$('#monaco-url').attr('class', 'error');
				alert(data.message);
			}
			});
		}
		$('#monaco-url').keydown(e => {
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code == 13) {
				monacoOpen();
			}
		});
		$('#monaco-open').click(monacoOpen);
		$('#monaco-save').click(monacoSave);
		$('.monaco #diff').click(function() {
			this.scrollIntoView();
			window.scrollBy(0, -32);
		})
	})(jQuery);
</script>
