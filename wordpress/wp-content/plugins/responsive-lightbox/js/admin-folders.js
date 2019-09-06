( function ( $ ) {

	var rl_folder_id = 0,
		rl_ps = null,
		grid_frame = null,
		active_mode = '',
		move_node_failed = false,
		disable_redirect = false,
		attachments_browser = null,
		last_priority = 2,
		event_data = {};

	// add new media folder filter
	wp.media.view.AttachmentFilters.RLFolders = wp.media.view.AttachmentFilters.extend( {
		id: 'media-attachment-rl-folders-filters',
		className: 'attachment-filters attachment-rl-folders-filter',
		change: function() {
			wp.media.view.AttachmentFilters.prototype.change.apply( this, arguments );

			if ( grid_frame !== null )
				grid_frame.controller.states.get( 'library' ).get( 'library' ).observe( wp.Uploader.queue );
		},
		createFilters: function() {
			var filters = {},
				term_id = 0,
				terms = $( $.parseHTML( rlFoldersArgs.terms ) ).find( 'option' );

			// root
			filters[0] = {
				text: rlFoldersArgs.root,
				priority: 1,
				props: {
					[rlFoldersArgs.taxonomy]: 0,
					'force_update': 0,
					'include_children': false
				}
			};

			// media folder
			if ( rlFoldersArgs.terms !== '' && terms.length > 0 ) {
				$( $.parseHTML( rlFoldersArgs.terms ) ).find('option').each( function( i, option ) {
					term_id = parseInt( $(option).val() );
					term_id = ( term_id === 0 ? 'all' : term_id );
					last_priority = i + 2;

					filters[term_id] = {
						text: $( option ).text(),
						priority: last_priority,
						props: {
							[rlFoldersArgs.taxonomy]: term_id,
							'force_update': 0,
							'include_children': false
						}
					};
				} );
			// all files
			} else {
				filters['all'] = {
					text: rlFoldersArgs.all_terms,
					priority: 1,
					props: {
						[rlFoldersArgs.taxonomy]: 'all',
						'force_update': 0,
						'include_children': true
					}
				};
			}

			this.filters = filters;
		}
	} );

	// extend AttachmentsBrowser 
	var RLFoldersAttachmentsBrowser = {
		initialize: wp.media.view.AttachmentsBrowser.prototype.initialize,
		createToolbar: wp.media.view.AttachmentsBrowser.prototype.createToolbar
	};

	$.extend( wp.media.view.AttachmentsBrowser.prototype, {
		initialize: function() {
			RLFoldersAttachmentsBrowser.initialize.apply( this, arguments );
		},
		createToolbar: function() {
			var filters = this.options.filters,
				self = this;

			attachments_browser = this;

			RLFoldersAttachmentsBrowser.createToolbar.apply( this, arguments );

			if ( $.inArray( filters, ['uploaded', 'all'] ) !== -1 ) {
				self.toolbar.set( 'rl-folders-filter', new wp.media.view.AttachmentFilters.RLFolders( {
					controller: self.controller,
					model: self.collection.props,
					// just before the bulk button (-70)
					priority: -71,
					taxonomy: rlFoldersArgs.taxonomy
				} ).render() );
			}
		}
	} );

	// extend AttachmentCompat 
	var RLAttachmentCompat = {
		save: wp.media.view.AttachmentCompat.prototype.save,
		postSave: wp.media.view.AttachmentCompat.prototype.postSave
	};

	$.extend( wp.media.view.AttachmentCompat.prototype, {
		save: function() {
			RLAttachmentCompat.save.apply( this, arguments );

			// display spinner
			this.$el.closest( '.attachment-details' ).removeClass( 'save-ready' ).addClass( 'save-waiting' );
		},
		postSave: function() {
			RLAttachmentCompat.postSave.apply( this, arguments );

			// hide spinner
			this.$el.closest( '.attachment-details' ).addClass( 'save-ready' ).removeClass( 'save-waiting' );
		}
	} );

	if ( typeof wp.Uploader !== 'undefined' ) {
		// extend uploader to apply dynamic folder ID
		$.extend( wp.Uploader.prototype, {
			init: function() {
				this.uploader.bind( 'BeforeUpload', function( file ) {
					file.settings.multipart_params.rl_folders_upload_files_term_id = rl_folder_id;
				} );
			}
		} );
	}

	// are we ready?
	$( document ).ready( function () {
		// do nothing for wp_enqueue_media
		if ( rlFoldersArgs.page === 'media' ) {
			// folder change
			$( document ).on( 'change', '#media-attachment-rl-folders-filters', function() {
				$( '#rl_folders_upload_files' ).val( $( this ).val() );
			} );
		} else {
			var active_nodes = [],
				plugins = ['sort', 'dnd'];

			// detect active library mode
			active_mode = ( $( 'body' ).hasClass( 'rl-folders-upload-grid-mode' ) ? 'grid' : 'list' );

			// add media folders container
			if ( active_mode === 'list' ) {
				// add tree
				$( '#posts-filter' ).before( rlFoldersArgs.template );

				// add spinner
				$( '.filter-items .actions' ).append( '<span class="spinner"></span>' );

				// initialize draggable
				draggable( 'list' );
			} else {
				// add tree
				$( '#wp-media-grid .error' ).after( rlFoldersArgs.template );
			}

			// activate wholerow plugin if needed
			if ( rlFoldersArgs.wholerow === '1' ) {
				plugins.push( 'wholerow' );
			}

			// initialize jstree
			$( '#rl-folders-tree' ).jstree( {
				'core': {
					'check_callback': function( operation, node, node_parent, node_position, more ) {
						// prevent moving folders to 'all files' folder
						return ! ( operation === 'move_node' && node_parent.parent === '#' && node_parent.a_attr['data-term_id'] === 'all' );
					},
					'multiple': false,
					'expand_selected_onload': false,
					'worker': false,
					'animation': 150
				},
				'dnd': {
					'is_draggable': function( object ) {
						// prevent moving main folders
						return ( object[0].parent !== '#' );
					}
				},
				'sort': function( a, b ) {
					// do not sort main and root nodes
					if ( a === 'j1_1' )
						return -1;
					else
						return this.get_text( a ).toLowerCase() > this.get_text( b ).toLowerCase() ? 1 : -1;
				},
				'plugins': plugins
			} );

			// apply theme
			$( '#rl-folders-tree' ).jstree( 'set_theme', rlFoldersArgs.theme );

			// handle folder click
			$( document ).on( 'click', '.jstree-anchor', click_node );

			// add new folder
			$( document ).on( 'click', '.rl-folders-add-new-folder', function() {
				// get current node
				var parent_node = $( '#rl-folders-tree' ).jstree().get_selected().toString();

				// create new node
				var new_node = $( '#rl-folders-tree' ).jstree( 'create_node', parent_node, rlFoldersArgs.new_folder, 'inside', function() {}, true );

				// deselect old node
				$( '#rl-folders-tree' ).jstree( 'deselect_node', parent_node );

				if ( active_mode === 'list' ) {
					// disable redirect in select_node
					disable_redirect = true;
				}

				// select new node
				$( '#rl-folders-tree' ).jstree( 'select_node', new_node, true, true );

				// open old node
				$( '#rl-folders-tree' ).jstree( 'open_node', parent_node, function() {
					var link = $( '#' + new_node + '_anchor' ),
						content = link.html().match( '<i(?:.+)?/i>' )[0],
						tree = $( '#rl-folders-tree' ).jstree( true ).get_json( '#', { 'flat': true } );

					// unbind event
					$( document ).off( 'click', '.jstree-anchor' );

					// disable all nodes
					$.each( tree, function( key, value ) {
						if ( value.state.selected == false ) {
							$( '#rl-folders-tree' ).jstree( 'disable_node', value.id );
						}
					} );

					// hide icons
					$( '.rl-folders-add-new-folder' ).hide();

					// show icons
					$( '.rl-folders-save-new-folder, .rl-folders-cancel-new-folder' ).show();

					// disable icons
					$( '.rl-folders-rename-folder, .rl-folders-delete-folder, .rl-folders-expand-folder, .rl-folders-collapse-folder' ).addClass( 'disabled-link' );

					// hide node, show input
					link.hide().after( '<span id="' + parent_node + '_span">' + content + '<input id="rl-folders-enter-new-folder" type="text" value="' + rlFoldersArgs.new_folder + '" placeholder="" data-term_id="' + parseInt( link.data( 'term_id' ) ) + '" data-nof="0" /></span>' );

					// select text inside input
					$( '#rl-folders-enter-new-folder' ).select();

					$( '#rl-folders-enter-new-folder' ).keyup( function( e ) {
						// enter button
						if ( e.which === 13 ) {
							save_node( true, parseInt( $( '#' + parent_node + '_anchor' ).data( 'term_id' ) ) );
						// escape button
						} else if ( e.which === 27 ) {
							restore_node( true, true );
						}
					} );
				}, $( '#rl-folders-tree' ).jstree().settings.core.animation );

				return false;
			} );

			// rename folder
			$( document ).on( 'click', '.rl-folders-rename-folder', function() {
				var node_id = $( '#rl-folders-tree' ).jstree().get_selected().toString(),
					link = $( '#' + node_id + '_anchor' ),
					term_id = link.data( 'term_id' );

				// prevent renaming main folders ('root' and 'all files')
				if ( term_id === 'all' || term_id === 0 ) {
					return false;
				}

				var content = link.html().match( '(<i(?:.+)?/i>)(.+)' ),
					split = content[2].split( ' ' ),
					nof = split.pop().match( /\d+/ )[0],
					name = split.join( ' ' ),
					tree = $( '#rl-folders-tree' ).jstree( true ).get_json( '#', { 'flat': true } );

				// unbind event
				$( document ).off( 'click', '.jstree-anchor' );

				// disable all nodes
				$.each( tree, function( key, value ) {
					if ( value.state.selected == false ) {
						$( '#rl-folders-tree' ).jstree( 'disable_node', value.id );
					}
				} );

				// hide icons
				$( '.rl-folders-rename-folder' ).hide();

				// show icons
				$( '.rl-folders-save-folder, .rl-folders-cancel-folder' ).show();

				// disable icons
				$( '.rl-folders-add-new-folder, .rl-folders-delete-folder, .rl-folders-expand-folder, .rl-folders-collapse-folder' ).addClass( 'disabled-link' );

				// hide node, show input
				link.hide().after( '<span id="' + node_id + '_span">' + content[1] + '<input id="rl-folders-enter-folder" type="text" value="' + name + '" placeholder="' + name + '" data-term_id="' + parseInt( term_id ) + '" data-nof="' + nof + '" /></span>' );

				// select text inside input
				$( '#rl-folders-enter-folder' ).select();

				$( '#rl-folders-enter-folder' ).keyup( function( e ) {
					// enter button
					if ( e.which === 13 ) {
						save_node( false );
					// escape button
					} else if ( e.which === 27 ) {
						restore_node( false, false );
					}
				} );

				return false;
			} );

			// save folder
			$( document ).on( 'click', '.rl-folders-save-folder', function() {
				save_node( false );

				return false;
			} );

			// save new folder
			$( document ).on( 'click', '.rl-folders-save-new-folder', function() {
				save_node( true, parseInt( $( '#' + $( '#rl-folders-tree' ).jstree().get_selected().toString() + '_anchor' ).data( 'term_id' ) ) );

				return false;
			} );

			// cancel renaming folder
			$( document ).on( 'click', '.rl-folders-cancel-folder', function() {
				restore_node( false, false );

				return false;
			} );

			// cancel adding new folder
			$( document ).on( 'click', '.rl-folders-cancel-new-folder', function() {
				restore_node( true, true );

				return false;
			} );

			// delete folder
			$( document ).on( 'click', '.rl-folders-delete-folder', function() {
				if ( ! $( this ).hasClass( 'disabled-link' ) && confirm( rlFoldersArgs.remove_children === '1' ? rlFoldersArgs.delete_terms : rlFoldersArgs.delete_term ) ) {
					// show spinner
					toggle_spinner( true );

					var node_id = $( '#rl-folders-tree' ).jstree().get_selected().toString(),
						term_id = parseInt( $( '#' + node_id + '_anchor' ).data( 'term_id' ) );

					// delete term with children using ajax
					$.post( ajaxurl, {
						action: 'rl-folders-delete-term',
						term_id: term_id,
						children: rlFoldersArgs.remove_children,
						nonce: rlFoldersArgs.nonce
					} ).done( function( response ) {
						try {
							if ( response.success ) {
								// get parent node
								var parent = $( '#rl-folders-tree' ).jstree( 'get_parent', node_id );

								// update upload select
								update_upload_select( $( response.data ).find( 'option' ) );

								// remove children?
								if ( rlFoldersArgs.remove_children === '0' && ! $( '#rl-folders-tree' ).jstree( 'is_leaf', node_id ) ) {
									// open removing node
									$( '#rl-folders-tree' ).jstree( 'open_node', node_id, function() {
										// move every child to a new parent
										$( '#rl-folders-tree' ).jstree( 'get_children_dom', node_id ).each( function( i, el ) {
											move_node( $( el ).attr( 'id' ), parent );
										} );
									}, $( '#rl-folders-tree' ).jstree().settings.core.animation );
								}

								// delete node
								$( '#rl-folders-tree' ).jstree( 'delete_node', node_id );

								// select parent node
								$( '#rl-folders-tree' ).jstree( 'select_node', parent );

								// force to update view
								$( '#media-attachment-rl-folders-filters' ).val( $( '#' + parent + '_anchor' ).data( 'term_id' ) ).change();

								refresh_scrollbars();
							} else {
								//@TODO
							}
						} catch( e ) {
							//@TODO
						}

						// hide spinner
						toggle_spinner( false );
					} ).fail( function() {
						// hide spinner
						toggle_spinner( false );
					} );
				}

				return false;
			} );

			// expand folder
			$( document ).on( 'click', '.rl-folders-expand-folder', function() {
				if ( ! $( this ).hasClass( 'disabled-link' ) ) {
					$( '#rl-folders-tree' ).jstree( 'open_all', $( '#rl-folders-tree' ).jstree().get_selected(), $( '#rl-folders-tree' ).jstree().settings.core.animation );
				}

				return false;
			} );

			// collapse folder
			$( document ).on( 'click', '.rl-folders-collapse-folder', function() {
				if ( ! $( this ).hasClass( 'disabled-link' ) ) {
					$( '#rl-folders-tree' ).jstree( 'close_all', $( '#rl-folders-tree' ).jstree().get_selected(), $( '#rl-folders-tree' ).jstree().settings.core.animation );
				}

				return false;
			} );

			// select folder event handler
			$( '#rl-folders-tree' ).on( 'select_node.jstree', function() {
				// get node id
				var node_id = $( '#rl-folders-tree' ).jstree().get_selected().toString();

				// list mode?
				if ( active_mode === 'list' ) {
					if ( disable_redirect ) {
						disable_redirect = false;
					} else {
						window.location.replace( $( '#' + node_id + '_anchor' ).attr( 'href' ) );
					}

					return;
				} else {
					// update mode links
					update_mode_link( 'grid' );
					update_mode_link( 'list' );
				}

				// get term id of selected node
				var term_id = $( '#' + node_id + '_anchor' ).data( 'term_id' );

				// select term id in dropdown
				$( '#rl_folders_upload_files' ).val( term_id === 'all' ? 0 : term_id );

				// update term_id in uploader parameters
				rl_folder_id = parseInt( term_id ) || 0;

				// enable/disable icons for folders
				if ( term_id === 'all' )
					$( '.rl-folders-add-new-folder, .rl-folders-rename-folder, .rl-folders-delete-folder' ).addClass( 'disabled-link' );
				else if ( term_id === 0 ) {
					$( '.rl-folders-rename-folder, .rl-folders-delete-folder' ).addClass( 'disabled-link' );
					$( '.rl-folders-add-new-folder' ).removeClass( 'disabled-link' );
				} else
					$( '.rl-folders-add-new-folder, .rl-folders-rename-folder, .rl-folders-delete-folder' ).removeClass( 'disabled-link' );

				// enable/disable icons for non-empty folders
				if ( $( '#rl-folders-tree' ).jstree( 'is_leaf', node_id ) )
					$( '.rl-folders-expand-folder, .rl-folders-collapse-folder' ).addClass( 'disabled-link' );
				else
					$( '.rl-folders-expand-folder, .rl-folders-collapse-folder' ).removeClass( 'disabled-link' );
			} );

			// rename node event
			$( '#rl-folders-tree' ).on( 'rename_node.jstree', function( event, tree ) {
				// new node?
				if ( event_data.create ) {
					// set term id
					tree.node.a_attr['data-term_id'] = event_data.response.term_id;

					// set url
					tree.node.a_attr.href = event_data.response.url;

					// clear event data
					event_data = {};
				}
			} );

			// jstree is ready
			$( '#rl-folders-tree' ).on( 'ready.jstree', function( e, data ) {
				if ( active_mode === 'list' ) {
					droppable( 'list' );
				}

				// initialize perfect scrollbar
				rl_ps = new PerfectScrollbar( '#rl-folders-tree', {
					wheelSpeed: 3,
					wheelPropagation: true,
					minScrollbarLength: 30
				} );

				// replace edit function to prevent using F2 key natively by jstree
				$.jstree.core.prototype.edit = function( obj, default_text, callback ) {
					$( '.rl-folders-rename-folder' ).click();
				};

				// update mode links
				update_mode_link( 'grid' );
				update_mode_link( 'list' );
			} );

			// close all folders event
			$( '#rl-folders-tree' ).on( 'close_all.jstree', function() {
				refresh_scrollbars();
			} );

			// open all folders event
			$( '#rl-folders-tree' ).on( 'open_all.jstree', function() {
				refresh_scrollbars();
			} );

			// open folder event handler
			$( '#rl-folders-tree' ).on( 'close_node.jstree', function() {
				refresh_scrollbars();
			} );

			// open folder event handler
			$( '#rl-folders-tree' ).on( 'open_node.jstree', function() {
				refresh_scrollbars();

				if ( active_mode === 'grid' ) {
					// refresh tree elements to make children of selected node droppable
					droppable( 'grid' );
				}
			} );

			// after ajax complete
			$( document ).on( 'ajaxComplete', function( event, xhr, object ) {
				// check ajax action
				var action = parse_str( 'action', object.data );

				// attachments were moved
				if ( action === 'rl-folders-move-attachments' ) {
					// refresh droppable
					droppable( active_mode );
				// built-in query attachments
				} else if ( action === 'query-attachments' ) {
					// initialize droppable
					droppable( 'grid' );

					// initialize draggable
					draggable( 'grid' );

					// empty frame?
					if ( grid_frame === null ) {
						// store grid frame
						grid_frame = wp.media.frame.content.get();

						// set root as main folder for uploads
						rl_folder_id = 0;
					}
				}
			} );

			// folder change
			$( document ).on( 'change', '#media-attachment-rl-folders-filters', function() {
				if ( active_mode === 'list' ) {
					return;
				}

				var node_id = $( '#rl-folders-tree' ).jstree().get_selected().toString();

				// visiting node for the first time?
				if ( typeof active_nodes[node_id] === 'undefined' )
					active_nodes[node_id] = true;
				else {
					var term_id = $( this ).val();

					// force ajax call
					grid_frame.collection.props.set( 'force_update', + new Date() );

					// make sure dropdown has valid term_id selected
					$( this ).val( term_id );
				}
			} );

			// change parent of the dragged folder
			$( '#rl-folders-tree' ).on( 'move_node.jstree', function( e, object ) {
				// prevent infinite loop
				if ( move_node_failed ) {
					move_node_failed = false;

					return false;
				}

				// show spinner
				toggle_spinner( true );

				$.post( ajaxurl, {
					action: 'rl-folders-move-term',
					term_id: parseInt( object.node.a_attr['data-term_id'] ),
					parent_id: parseInt( $( '#' + object.parent + '_anchor' ).data( 'term_id' ) ),
					nonce: rlFoldersArgs.nonce
				} ).done( function( response ) {
					try {
						if ( response.success ) {
							// update upload select
							update_upload_select( $( response.data ).find( 'option' ) );

							// open parent node
							$( '#rl-folders-tree' ).jstree( 'open_node', object.parent, '', $( '#rl-folders-tree' ).jstree().settings.core.animation );
						} else {
							move_node( object.node.id, object.old_parent, object.old_position );
						}
					} catch( e ) {
						move_node( object.node.id, object.old_parent, object.old_position );
					}

					// hide spinner
					toggle_spinner( false );
				} ).fail( function() {
					move_node( object.node.id, object.old_parent, object.old_position );

					// hide spinner
					toggle_spinner( false );
				} );
			} );

			$( document ).on( 'click', '.select-mode-toggle-button', function() {
				if ( grid_frame.controller.isModeActive( 'select' ) ) {
					// refresh draggable
					draggable( 'grid' );
				} else {
					// hide filters
					$( '#media-attachment-rl-folders-filters' ).hide();
				}
			} );
		}

		// change uploading folder
		$( document ).on( 'change', '#rl_folders_upload_files', function() {
			// update term_id in uploader parameters
			rl_folder_id = parseInt( $( this ).val() ) || 0;
		} );
	} );

	// update mode link (grid or list)
	function update_mode_link( mode ) {
		var selector = $( '.view-switch > a.view-' + mode ),
			link = selector.prop( 'href' );

		// get query string
		var query = link.split( 'upload.php' )[1];

		// parse query string
		var string = parse_str( rlFoldersArgs.taxonomy, query );

		// get term_id
		var term = $( '#' + $( '#rl-folders-tree' ).jstree().get_selected().toString() + '_anchor' ).data( 'term_id' );

		if ( mode === 'list' ) {
			// 'all' on grid is 0 on list
			if ( term === 'all' ) {
				term = 0;
			// -1 on list is 0 on grid
			} else if ( term === 0 ) {
				term = -1;
			}
		}

		// no 'taxonomy=term_id' in query?
		if ( string === '' ) {
			selector.prop( 'href', link + '&' + rlFoldersArgs.taxonomy + '=' + term );
		// found pair so replace term_id with new one just in case it's invalid
		} else {
			selector.prop( 'href', link.replace( new RegExp( rlFoldersArgs.taxonomy + '=' + '(-?[0-9]+|all)', 'g' ), rlFoldersArgs.taxonomy + '=' + term ) );
		}
	}

	// refresh perfect scrollbar
	function refresh_scrollbars() {
	setTimeout( function() {
			rl_ps.update();
		}, 200 );
	}

	// droppable (skip 'all files')
	function droppable( mode ) {
		// var node_id = $( '#rl-folders-tree' ).jstree().get_selected().toString();
		var node_id = $( '#rl-folders-tree' ).jstree( 'get_selected', false );

		// is wholerow plugin active?
		if ( rlFoldersArgs.wholerow === '1' ) {
			var wholerow = $( 'div.jstree-wholerow.jstree-wholerow-clicked' );

			// destroy only selected droppable node first if needed
			if ( typeof wholerow.droppable( 'instance' ) !== 'undefined' ) {
				wholerow.droppable( 'destroy' );
			}

			// droppable nodes selector, skip 'all files' and current folder
			selector = $( '#rl-folders-tree .jstree-wholerow:not(:eq(0))' ).not( '#' + node_id + ' .jstree-wholerow-clicked' );
		} else {
			var anchor = $( '#' + node_id + '_anchor' );

			// destroy only selected droppable node first if needed
			if ( typeof anchor.droppable( 'instance' ) !== 'undefined' ) {
				anchor.droppable( 'destroy' );
			}

			// droppable nodes selector, skip 'all files' and current folder
			selector = $( '#rl-folders-tree li a.jstree-anchor:not(:eq(0),#' + node_id + '_anchor)' );
		}

		// list mode
		if ( mode === 'list' ) {
			selector.droppable( {
				activeClass: 'rl-folders-state-active',
				hoverClass: 'rl-folders-state-hover',
				accept: '#the-list tr',
				tolerance: 'pointer',
				drop: function( event, ui ) {
					var node = $( event.target ).closest( 'li' ).find( 'a.jstree-anchor' ),
						old_node = $( '#' + $( '#rl-folders-tree' ).jstree().get_selected().toString() + '_anchor' ),
						old_term_id = parseInt( old_node.data( 'term_id' ) ) || -1,
						attachments = [],
						ids = $( '#the-list .check-column input[type="checkbox"]:checked' );

					toggle_spinner( true );

					// dropped single unchecked attachment?
					if ( ids.length === 0 ) {
						attachments.push( ui.draggable.find( '.check-column input[type="checkbox"]' ).val() );
					} else {
						ids.each( function( i, item ) {
							attachments.push( parseInt( $( item ).val() ) );
						} );
					}

					$.post( ajaxurl, {
						action: 'rl-folders-move-attachments',
						attachment_ids: attachments,
						old_term_id: old_term_id,
						new_term_id: parseInt( node.data( 'term_id' ) ) || -1,
						nonce: rlFoldersArgs.nonce
					} ).done( function( response ) {
						try {
							if ( response.success ) {
								// do not update 'all files' folder or remove attachments from there
								if ( old_term_id !== -1 ) {
									// remove attachments
									for ( i = 0; i < response.data.attachments.success.length; i++ ) {
										$( '#post-' + response.data.attachments.success[i] ).fadeOut( 'fast', function() {
											$( this ).remove();

											// display 'no media' text
											if ( $( '#the-list tr' ).length === 0 ) {
												$( '#the-list' ).append( rlFoldersArgs.no_media_items );
											}
										} );
									}
 
									// update old node number
									update_node_number( old_node, response.data, false );
								}

								// update new node number
								update_node_number( node, response.data );
							}
						} catch( e ) {
							
						}

						// hide spinner
						toggle_spinner( false );
					} ).fail( function() {
						// hide spinner
						toggle_spinner( false );
					} );
				}
			} );
		// grid mode
		} else {
			selector.droppable( {
				activeClass: 'rl-folders-state-active',
				hoverClass: 'rl-folders-state-hover',
				accept: 'li.attachment',
				tolerance: 'pointer',
				drop: function( event, ui ) {
					var node = $( event.target ).closest( 'li' ).find( 'a.jstree-anchor' ),
						old_node = $( '#' + $( '#rl-folders-tree' ).jstree().get_selected().toString() + '_anchor' ),
						term_id = old_node.data( 'term_id' ),
						old_term_id = term_id === 'all' ? -1 : parseInt( term_id ),
						attachments = [];

					toggle_spinner( true );

					// single attachment
					if ( $( '.media-frame' ).hasClass( 'mode-edit' ) ) {
						attachments.push( parseInt( ui.draggable.data( 'id' ) ) );
					// selection of attachments
					} else {
						$( 'ul.attachments > li.selected' ).each( function( i, item ) {
							attachments.push( parseInt( $( item ).data( 'id' ) ) );
						} );
					}
console.log( old_term_id );
console.log( parseInt( node.data( 'term_id' ) ) );
console.log( rlFoldersArgs.counters );
					$.post( ajaxurl, {
						action: 'rl-folders-move-attachments',
						attachment_ids: attachments,
						old_term_id: old_term_id,
						new_term_id: parseInt( node.data( 'term_id' ) ),
						nonce: rlFoldersArgs.nonce
					} ).done( function( response ) {
						try {
							if ( response.success ) {
								// do not update 'all files' folder or remove attachments from there
								if ( old_term_id !== -1 ) {
									// remove attachments
									for ( i = 0; i < response.data.attachments.success.length; i++ ) {
										$( 'ul.attachments li[data-id="' + response.data.attachments.success[i] + '"]' ).fadeOut( 'fast', function() {
											$( this ).remove();

											// display 'no media' text
											if ( $( 'ul.attachments li' ).length === 0 ) {
												$( '.no-media' ).removeClass( 'hidden' );
											}
										} );
									}

									// update old node number
									update_node_number( old_node, response.data, false );
								}

								// update new node number
								update_node_number( node, response.data );

								// deactivate select mode and activate edit mode
								grid_frame.controller.deactivateMode( 'select' ).activateMode( 'edit' );
							}
						} catch( e ) {
							
						}

						// hide spinner
						toggle_spinner( false );
					} ).fail( function() {
						// hide spinner
						toggle_spinner( false );
					} );
				}
			} );
		}
	}

	// draggable
	function draggable( mode ) {
		// grid mode
		if ( mode === 'grid' ) {
			var nof = 0;

			$( '.media-frame-content ul.attachments li' ).draggable( {
				helper: function() {
					var attachments = 1;

					// grid mode
					if ( active_mode === 'grid' ) {
						// single attachment
						if ( $( '.media-frame' ).hasClass( 'mode-edit' ) )
							attachments = 1;
						// selection of attachments
						else
							attachments = $( 'ul.attachments li.selected' ).length;
					// list mode
					} else
						attachments = $( '#the-list .check-column input[type="checkbox"]:checked' ).length;

					// pass number of attachments to drag event
					nof = attachments;

					return '<div class="rl-folders-dragged-item"><div class="dashicons dashicons-media-default"></div><span>' + attachments + '</span></div>';
				},
				drag: function() {
					if ( nof === 0 )
						return false;
				},
				appendTo: 'body',
				distance: 3,
				cursor: 'move',
				cursorAt: { top: 20, left: 20 },
				containment: '#wpwrap',
				revert: 'invalid',
				zIndex: 999
			} );
		// list mode
		} else {
			$( '#the-list tr' ).draggable( {
				helper: function() {
					var attachments = $( '#the-list .check-column input[type="checkbox"]:checked' ).length;

					// dragging unchecked single attachment?
					if ( attachments === 0 ) {
						attachments = 1;
					}

					return '<div class="rl-folders-dragged-item"><div class="dashicons dashicons-media-default"></div><span>' + attachments + '</span></div>';
				},
				appendTo: 'body',
				distance: 3,
				cursor: 'move',
				cursorAt: { top: 20, left: 20 },
				containment: '#wpwrap',
				revert: 'invalid',
				zIndex: 999
			} );
		}
	}

	// update number of attachments of specified node
	function update_node_number( node, data, add = true ) {
		var html = node.html().split( /(?:<i(?:.+)?\/i>)(.+)\s\((\d+)\)/ );

		// rename node
		$( '#rl-folders-tree' ).jstree( 'rename_node', node.parent().attr( 'id' ), html[1] + ' (' + ( parseInt( html[2] ) + ( add ? data.attachments.success.length - data.attachments.duplicated.length : - data.attachments.success.length ) ) + ')' );
	}

	// toggle spinner
	function toggle_spinner( show ) {
		if ( show ) {
			if ( active_mode === 'list' ) {
				$( '.filter-items .actions' ).find( '.spinner' ).addClass( 'is-active' );
			} else {
				$( '.media-toolbar-secondary' ).find( '.spinner' ).addClass( 'is-active' );
			}
		} else {
			if ( active_mode === 'list' ) {
				$( '.filter-items .actions' ).find( '.spinner' ).removeClass( 'is-active' );
			} else {
				$( '.media-toolbar-secondary' ).find( '.spinner' ).removeClass( 'is-active' );
			}
		}
	}

	// move back node to old parent and position
	function move_node( node, parent, position ) {
		// set this to prevent infinite loop
		move_node_failed = true;

		// move back node
		$( '#rl-folders-tree' ).jstree( 'move_node', node, parent, position );
	}

	// cancel renaming/adding node
	function restore_node( new_node, cancel ) {
		var node_id = '#' + $( '#rl-folders-tree' ).jstree().get_selected().toString(),
			tree = $( '#rl-folders-tree' ).jstree( true ).get_json( '#', { 'flat': true } );

		// show icon
		$( new_node ? '.rl-folders-add-new-folder' : '.rl-folders-rename-folder' ).show();

		// hide icons
		$( new_node ? '.rl-folders-save-new-folder, .rl-folders-cancel-new-folder' : '.rl-folders-save-folder, .rl-folders-cancel-folder' ).hide();

		// enable icons
		$( new_node ? '.rl-folders-rename-folder, .rl-folders-delete-folder' : '.rl-folders-add-new-folder, .rl-folders-delete-folder' ).removeClass( 'disabled-link' );

		if ( new_node && cancel ) {
			// get parent node
			var parent = $( '#rl-folders-tree' ).jstree( 'get_parent', node_id );

			// delete node
			$( '#rl-folders-tree' ).jstree( 'delete_node', node_id );

			if ( active_mode === 'list' ) {
				// disable redirect in select_node
				disable_redirect = true;
			}

			// select parent node
			$( '#rl-folders-tree' ).jstree( 'select_node', parent );
		} else {
			// enable icons for non-empty nodes
			if ( ! $( '#rl-folders-tree' ).jstree( 'is_leaf', node_id ) ) {
				$( '.rl-folders-expand-folder, .rl-folders-collapse-folder' ).removeClass( 'disabled-link' );
			}

			// restore folder
			$( node_id + '_span' ).remove();
			$( node_id + '_anchor' ).show();
		}

		// enable all nodes
		$.each( tree, function( key, value ) {
			$( '#rl-folders-tree' ).jstree( 'enable_node', value.id );
		} );

		// refresh droppable nodes
		droppable( active_mode );

		// rebind event
		$( document ).on( 'click', '.jstree-anchor', click_node );
	}

	// save node with new name
	function save_node( new_node, parent_id = 0 ) {
		var input = $( new_node ? '#rl-folders-enter-new-folder' : '#rl-folders-enter-folder' );
			node_id = $( '#rl-folders-tree' ).jstree().get_selected().toString(),
			name = $.trim( input.val() ),
			nof = input.data( 'nof' ),
			term_id = parseInt( input.data( 'term_id' ) );

		// empty or the same name?
		if ( name === '' || name === input.attr( 'placeholder' ) ) {
			restore_node( new_node, true );

			return false;
		}

		// show spinner
		toggle_spinner( true );

		$.post( ajaxurl, new_node ? {
			action: 'rl-folders-add-term',
			parent_id: parent_id,
			name: name,
			nonce: rlFoldersArgs.nonce
		} : {
			action: 'rl-folders-rename-term',
			term_id: term_id,
			name: name,
			nonce: rlFoldersArgs.nonce
		} ).done( function( response ) {
			try {
				if ( response.success ) {
					if ( new_node ) {
						// add new folder to dropdown
						$( '#media-attachment-rl-folders-filters' ).append( '<option value="' + response.data.term_id + '">' + response.data.name + '</option>' );

						// update filters
						attachments_browser.toolbar.get( 'rl-folders-filter' ).filters[response.data.term_id] = {
							text: response.data.name,
							priority: last_priority + 1,
							props: {
								[rlFoldersArgs.taxonomy]: response.data.term_id,
								'force_update': 0,
								'include_children': false
							}
						};
					} else {
						// rename node
						$( '#media-attachment-rl-folders-filters option[value="' + term_id + '"]' ).text( response.data.name );
						$( '#media-attachment-rl-folders-filters option[value="' + term_id + '"]' ).prop( 'selected', true );
					}

					// pass data to rename_node event
					event_data = {
						response: response.data,
						create: new_node
					};

					// rename node
					$( '#rl-folders-tree' ).jstree( 'rename_node', node_id, response.data.name + ' (' + nof + ')' );

					// sort node
					$( '#rl-folders-tree' ).jstree( 'sort', node_id, false );

					if ( new_node ) {
						// add term id and new url
						$( '#' + node_id + '_anchor' ).attr( 'data-term_id', response.data.term_id ).attr( 'href', response.data.url );

						// force to update view
						$( '#media-attachment-rl-folders-filters' ).val( response.data.term_id ).change();
					}

					// update upload select
					update_upload_select( $( response.data.select ).find( 'option' ), new_node ? response.data.term_id : term_id );
				}

				restore_node( new_node, false );
			} catch( e ) {
				restore_node( new_node, true );
			}

			// hide spinner
			toggle_spinner( false );
		} ).fail( function() {
			// hide spinner
			toggle_spinner( false );

			restore_node( new_node, true );
		} );
	}

	// update upload select
	function update_upload_select( options, selected = '' ) {
		$( '#rl_folders_upload_files' ).empty().append( options ).val( selected );
	}

	// click node handler
	function click_node() {
		$( '#media-attachment-rl-folders-filters' ).val( $( this ).data( 'term_id' ) ).change();
	}

	// parse query string
	function parse_str( name, str ) {
		var regex = new RegExp( '[?&]' + name.replace( /[\[\]]/g, '\\$&' ) + '(=([^&#]*)|&|#|$)' ),
			results = regex.exec( '&' + str );

		return ( ! results || ! results[2] ? '' : decodeURIComponent( results[2].replace( /\+/g, ' ' ) ) );
	}

} )( jQuery );