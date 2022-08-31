   <SelectControl
                    multiple
                    label={ __( 'Select some users:' ) }
                    value={ this.state.users } // e.g: value = [ 'a', 'c' ]
                    onChange={ ( users ) => {
                        this.setState( { users } );
                    } }
                    options={ [
                        { value: '', label: 'Select a User', disabled: true },
                        { value: 'a', label: 'User A' },
                        { value: 'b', label: 'User B' },
                        { value: 'c', label: 'User c' },
                    ] }
                    __nextHasNoMarginBottom
                />
https://wordpress.stackexchange.com/questions/363285/how-to-use-getentityrecords-for-user-data
https://wordpress.stackexchange.com/questions/383176/how-to-query-multiple-post-types-inside-gutenberg-options-panel
https://gist.github.com/igorbenic/970abd2e503c6c976fde0ae6d0172193
https://github.com/WordPress/gutenberg/tree/trunk/packages/components/src/select-control
https://awhitepixel.com/blog/wordpress-gutenberg-create-custom-block-part-10-fetching-posts-higher-order-components/