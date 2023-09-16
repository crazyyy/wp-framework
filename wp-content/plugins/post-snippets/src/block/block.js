const { __ } = wp.i18n; // Import __() from wp.i18n
const { SelectControl, TextControl, Placeholder } = wp.components;

// const { ServerSideRender } = wp.editor;

// import { SelectControl } from '@wordpress/components';
// import { useState } from '@wordpress/element';

// function get_snippet_vars(event){ /**Event only has option Value here */
//     console.log("Outside Function:\n");

//     console.log(event);
// }

const { Component } = wp.element;
const { Spinner } = wp.components;

// const state = {list:{}, loading: true};
// var loadingVar;
var gobal_check;

var all_snippets_php = all_snippets.all_snippets.data;

var snippet_vars_global = {};

var  rest_request_already = [];

// console.log(`All Snippets From Localized_Scripts:`);
// console.log(all_snippets_php);
 
class BlockEdit extends Component {
	constructor(props) {
		
        super(props);

        // console.log(`Global Variable:\n${gobal_check}`);
        // console.log(`Global Variable Var:\n${loadingVar}`);

		this.state = {
			list: {},
			loading: true,
            listVar: {},
            loadingVar: true,
            snippetSelected: false
		}

        this.AllSnippetsSelect = this.AllSnippetsSelect.bind(this);
        this.getSnippetVars = this.getSnippetVars.bind(this);
        this.SnippetVars = this.SnippetVars.bind(this);
	}
 
	componentDidMount() {
		// this.runApiFetch(106);
		
        // this.getAllSnippets();

        console.log(`Snippet ID:`);
        console.log(this?.props?.attributes?.snippetID);

        if(typeof this?.props?.attributes?.snippetID !== "undefined"){

            this.getSnippetVarsRest( this.props.attributes.snippetID );
            this.setState({
				snippetSelected: true
			});


        }

	}
 
	getAllSnippets() {
		wp.apiFetch({
			path: 'post-snippets/v1/all-snippets',
		}).then(data => {

			this.setState({
				list: data,
				loading: false
			});

            gobal_check = "Hello Global";
            
		});
	}


    AllSnippetsSelect(){

        // {Object.entries(php_data).map((vars, index) => (

        //     // all_snippets_options = [
        //     //     {}
        //     // ]

        console.log(this.props);

        //     // <>
        //     // {/* <p>{index}</p> */}
        //     // <p>{vars}</p>
        //     // </>
        var allSnippetsOptions = [{ value: -1, label: __( 'Select Snippet:' ), disabled: true }];

        // console.log(`All Snippets From Rest:\n`);
        // console.log(this.state.list);

        // var all_snippets_options = this.state.list;
        var all_snippets_options = all_snippets_php;

        for ( const [key, value] of Object.entries(all_snippets_options) ) {
            console.log(`${key}: ${value}`);

            allSnippetsOptions.push(
                {value: key, label: value}
            );


        }
        // ))}

        // const allSnippetsOptions = Object.entries(this.state.list).map((val, index) => {
        //     // <option value={key}>{tifs[key]}</option>
        //         console.log(val);
        //         console.log(index);
        
        //     }
        // );

        // console.log(allSnippetsOptions);

        // console.log("Not Undefined");
        // console.log(this?.props?.attributes?.snippetDetails?.snippet_ID);

        return(

            <>

            {/* <h1>Heelo From All Snippets</h1> */}

            <SelectControl
                // multiple
                label={ __( 'Select Snippet:' ) }
                value={ (this?.props?.attributes?.snippetID)?(this?.props?.attributes?.snippetID):-1 } // e.g: value = [ 'a', 'c' ]
                // onChange={ ( users ) => {
                //     this.setState( { users } );
                // } }
                onChange = {this.getSnippetVars}
                options  = {allSnippetsOptions}
                // options={ [
                //     { value: null, label: 'Select a User', disabled: true },
                //     { value: 'a', label: 'User A' },
                //     { value: 'b', label: 'User B' },
                //     { value: 'c', label: 'User c' },
                // ] }
            />



            </>

        );


        
    }

    SnippetVars(){

        console.log("List Var");
        console.log(this.state.listVar);
        
        var varTextFields = [];

        for (const [key, value] of Object.entries(this.state.listVar)) {
            console.log(`${key}: ${value}`);

            // console.log("type of Saved Atts Vars:");
            // console.log( typeof this.props.attributes.snippetVars[key] );


            // console.log("Saved Atts Vars:");
            // console.log( this.props.attributes.snippetVars[key] );

            if( typeof this.props.attributes.snippetVars !== "undefined" && this.props.attributes.snippetVars.hasOwnProperty(key) ){      //replacing default already loaded vars with atts vars

                var default_value = this.props.attributes.snippetVars[key];
            }

            else{

                var default_value = value
            }

            console.log("Default Val:");
            console.log( default_value );



            varTextFields.push(

                <TextControl
                    label = {key}
                    // defaultValue = { default_value }
                    value = { default_value }
                    onChange ={ ( props ) => {

                        // console.log("Snippet vars From Atts");
                        // console.log(this.props.attributes.snippetVars);
                        
                        // console.log("Snippet vars Type");
                        // console.log(typeof this.props.attributes.snippetVars);

                        
                        this.setState({
                            // listVar: data,
                            loadingVar: false
                        });



                        if(typeof this.props.attributes.snippetVars !== "undefined"){

                            var snippet_vars = this.props.attributes.snippetVars;
                        }
                        else{
                            var snippet_vars = {};
                        }

                        // console.log("Snippet _vars");
                        // console.log(snippet_vars);

                        snippet_vars[key] = props;

                        this.props.setAttributes( {snippetVars: snippet_vars } );

                        // this.props.snippetVars = { [key]:props };

                    } }
                />


                // <>
                //     <label htmlFor="">{key}</label><br />
                //     <input
                //         type = "text"
                //         defaultValue = {value}
                //         // label = {key}
                //         // value = { value }
                //         onChange ={ ( props ) => {

                //             console.log(props);

                //             this.props.snippetVars = { [key]:props.target.value };

                //         } }
                //     />

                // </>

            );



        }

        return(

            varTextFields

        );


    }

    getSnippetVars(props){

        console.log("type of Snippet Vars Global");
        console.log(typeof snippet_vars_global[props]);

        // if(! rest_request_already.includes(props) ){
            
        //     rest_request_already.push(props);   /**Request For the same ID already send */
        // }
            

        if(typeof snippet_vars_global[props] !== "undefined"){

            console.log("Already Snippet Vars Global");
            console.log( snippet_vars_global[props] );

            // if(){

            // }

            this.setState({         /**Setting ListVar to Already Updated Global Vars for Textcontrol to render */
				listVar: snippet_vars_global[props],
				loadingVar: false,
                snippetSelected: true
			});

            // console.log()
            this.props.setAttributes({snippetID:props});


            return;

        }

        this.setState({
            loadingVar: true
        });

        this.props.setAttributes({snippetID:props});


        // rest_request_already = false;
        // rest_request_already.push(props);
        
        /**This above var is for checking multiple blocks with same id on single page,
         * without it, if a page has two similar blocks, rest is called two times
        */


        this.getSnippetVarsRest(props);

        this.setState({
            snippetSelected: true
        });

    }

	getSnippetVarsRest(snippet_id) {


        // if(typeof rest_request_already[snippet_id] === "undefined"){
            
        //     rest_request_already.push(snippet_id);
        
        // }

        console.log("Type of Rest Request Already:");
        console.log(typeof rest_request_already[snippet_id] );


        console.log("Rest Request Already:");
        console.log( rest_request_already );



        // if(! rest_request_already.includes(snippet_id) ){
            
            rest_request_already.push(snippet_id);

            
        // if(!rest_request_already && ( typeof snippet_vars_global[snippet_id] === "undefined" ) ){

        /**This above condition is for checking multiple blocks with same id on single page,
         * without it, if a page has two similar blocks, rest is called two times
        */

            // rest_request_already = true;
        
            wp.apiFetch({
                path: 'post-snippets/v1/snippet-vars/' + snippet_id,
            }).then(data => {

                
                snippet_vars_global[snippet_id] = data;

                console.log("Snippet Vars Global");
                console.log( snippet_vars_global );

                
                this.setState({
                    listVar: data,
                    loadingVar: false
                });


                /** Getting State of all snippets in a Page */
                // var desired_block_ids = [];
                // all_block_in_a_page.forEach(block => {

                //     if(block.name == "wpexperts/post-snippets-block"){
                //         desired_block_ids.push(block.clientId);

                //     }
                // });
                /** 
                 * Look for Dispatcher
                 * 
                */

                
            });


        // }


	}
 
	render() {
		return(
			
            <Placeholder icon = "admin-plugins" label = {__("  Post Snippets")} className = "is-small">

            <div>



				{/* { (this.state.loading) ? (
					<Spinner />
				) : 
                
                    // console.log(this.state.list)

                    
                    
                    
                (
                    
					// <p>Data is ready! {JSON.stringify(this.state.list)}</p>
                
                    <>
                        <this.AllSnippetsSelect />
                        <p>Data is ready!</p>
                    </>
				)
                
                } */}




				
                <this.AllSnippetsSelect />


                
                { (this.state.snippetSelected) ? (


                    (this.state.loadingVar) ? (
                                        
                        <Spinner />

                    ) :
                        
                    (
                        
                        // <p>Data is ready! {JSON.stringify(this.state.list)}</p>

                        <>
                            <this.SnippetVars />
                            {/* <p>Data is ready!</p> */}
                        </>
                    )


				    ): null
                
                }


			</div>

            </Placeholder >

		);
 
	}
}






















wp.blocks.registerBlockType("wpexperts/post-snippets-block", {
    title: __( 'Post Snippets New' ),
    icon: "admin-plugins",
    category: "common",
    supports: {
        // Remove support for an HTML mode.
        html: false
    },
    keywords: [
		__( 'post snippets' ), __( 'snippets' ),
	],
    attributes: {
        skyColor: {type: "string"},
        grassColor: {type: "string"},
        snippetID: {type: "string"},
        snippetVars: {type: "object"}
    },
    edit: BlockEdit,
    // edit: (props) => {

    //     // return wp.element.createElement("h3", null, "Hello, this is from the admin Editor screen.")

    //     // return <h3>This is h3 from JSX!!</h3>

    //     // console.log(php_data);
    //     // console.log(Object.entries(php_data));

    //     // jQuery.ajax({
    //     //     url: php_data.admin_url,
    //     //     data: {
    //     //         'action': 'get_all_snippets',
    //     //         'data'  :  "Hello"
    //     //     },
    //     //     type: 'POST',

    //     //     success:function (result) {
                
	// 	// 		console.log(result);

    //     //         // $('.modal-content').html(result);
    //     //         // $('.modal').fadeIn();
    //     //         // $('body').addClass('body_class');
    //     //     }
    //     // });


    //     function get_snippet_vars(event){ /**Event only has option Value here */
            
    //         console.log("Outside Function:\n");
    //         props.setAttributes({ snippetDetails:{
    //                                     "snippet_ID": event,
    //                                     "snippet_vars":{
    //                                         "first":"Hello",
    //                                         "second":"World"
    //                                     }
    //                                 } 
    //                             });
    //         console.log(event);
    //         // console.log(props);

    //         jQuery.ajax({
    //                 url: php_data.admin_url,
    //                 data: {
    //                     'action': 'get_all_snippets',
    //                     'data'  :  "Hello"
    //                 },
    //                 type: 'POST',
        
    //                 success:function (result) {
                        
    //                     jQuery('.post_snippets_block').append(`<h3>Hello</h3>`);
    //             		console.log(result);
        
    //                     // $('.modal-content').html(result);
    //                     // $('.modal').fadeIn();
    //                     // $('body').addClass('body_class');
    //                 }
    //         });

    //     }

    //     console.log("Attributes:\n");
    //     console.log(props);

    //     return(

            
    //         <div className="post_snippets_block">

    //             <SelectControl
    //                 // multiple
    //                 label={ __( 'Select some users:' ) }
    //                 value={ props.attributes.snippetDetails.snippet_ID } // e.g: value = [ 'a', 'c' ]
    //                 // onChange={ ( users ) => {
    //                 //     this.setState( { users } );
    //                 // } }
    //                 onChange={get_snippet_vars}
    //                 options={ [
    //                     { value: null, label: 'Select a User', disabled: true },
    //                     { value: 'a', label: 'User A' },
    //                     { value: 'b', label: 'User B' },
    //                     { value: 'c', label: 'User c' },
    //                 ] }
    //             />

                
                
    //             {Object.entries(php_data).map((vars, index) => (
    //                     <>
    //                     {/* <p>{index}</p> */}
    //                     <p>{vars}</p>
    //                     </>
    //                 ))}

    //             <input type="text" placeholder="sky color" value={props.attributes.skyColor} onChange={ (e)=>{
    //                 props.setAttributes({skyColor: e.target.value})
    //             } } />
    //             <input type="text" placeholder="grass color" value={props.attributes.grassColor} onChange={ (e)=>{
    //                 props.setAttributes({grassColor: e.target.value})
    //             } } />
    //         </div>
    //     )

    // },
    save: function(props){
        return null
    }
})