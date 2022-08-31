const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.blockEditor;
const { withSelect ,useSelect } = wp.data;
const {SelectControl, PanelBody,TextControl } = wp.components;
const { createElement: el } = wp.element;

const { __ } = wp.i18n; // Import __() from wp.i18n
const { serverSideRender: ServerSideRender } = wp;
import './style.scss';
registerBlockType('custom-block/custom-users-list-block',{
    title: __('Custom Users block by Ibrahim','custom-users-block'),
    category: 'common',
    icon: 'buddicons-buddypress-logo',
    keywords: ['custom','my'],
    attributes: {
        userId: {
            type: 'init',
        },
        email: {
            type: 'string',
        },
        options: {
            type: 'array',
        },
        emailFilter: {
            type:'string',
            default:'@rgbc.dev'
        }
    },

    edit:	withSelect ( select => {
        return {
            data: select('core').getEntityRecords('root', 'user', {per_page: -1 })
        };
    })( ( props ) =>{

        const { data, isSelected, attributes, setAttributes } = props;
        var userId = props.attributes.userId;
        var email = props.attributes.email;
        var emailFilter = props.attributes.emailFilter;
        let UserData = [];
        //select users
        function onChangeUser(content) {
            props.setAttributes({userId: content })
        }
        // email filter by domain name
        function onChangeEmailFilter(content) {

            props.setAttributes({ emailFilter: content })
        }
        if( null != data){
             UserData = data.filter((user) => user.email.includes(emailFilter));
        }
        // options for SelectControl
        var options = [];

        // if posts found
        if( UserData ) {
            options.push( { disabled: true,value: 0, label: 'Select something' } );
            UserData.forEach((user) => { // simple foreach loop
                options.push( { value:user.id, label:user.name } );
            });
        } else {
            options.push( { value: 0, label: 'Loading...' } )
        }

        return (
            <>
                {/*{*/}
                {/*    <ol> {UserData.map( user => el( 'li', {*/}
                {/*        key: user.id }, ' User Name: ' + user.name, ' Email:' + user.email )*/}
                {/*    )}*/}
                {/*    </ol>*/}
                {/*}*/}
                {
                    //console.log(UserData)
                }
                <ServerSideRender block="custom-block/custom-users-list-block" attributes={attributes}/>
                <InspectorControls>
                    <PanelBody  title="Select Users"  initialOpen={ true }>
                        <SelectControl
                            style={{height: 'auto'}}
                            multiple
                            label={ __( 'Select some users:' ) }
                            value={  userId } // e.g: value = [ 'a', 'c' ]
                            onChange={onChangeUser}
                            options={options}
                        __nextHasNoMarginBottom
                        />
                        <TextControl
                            label={ __( 'Email filter' ) }
                            help={__( 'Email filter by domain name e.g @rgbc.dev' )}
                            type={'text'}
                            value={emailFilter}
                            onChange={onChangeEmailFilter}
                        />
                    </PanelBody>
                </InspectorControls>
            </>
        )

    } ),
    save: function (attributes) {
            // Rendering in PHP
            return null;
        },
});
