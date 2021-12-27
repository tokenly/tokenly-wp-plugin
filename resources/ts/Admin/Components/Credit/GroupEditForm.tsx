import * as React from 'react';
import { Component } from 'react';

import { 
	Button,
	Spinner,
	TextControl,
	TextareaControl,
	Flex,
} from '@wordpress/components';

interface GroupEditFormProps {
	loadingGroup: boolean;
	saving: boolean;
	onSave: any;
	onCancel: any;
	group: any;
}

interface GroupEditFormState {
	group: any;
}

export default class GroupEditForm extends Component<GroupEditFormProps, GroupEditFormState> {
	state: GroupEditFormState = {
		group: {
			name: null,
			app_whitelist: null,
		},
	};
	constructor( props: GroupEditFormProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
	}
	
	onSave() {
		let whitelist = this.state.group.app_whitelist.replace( /\s/g, '' );
		if ( whitelist == '' ) {
			whitelist = [];
		} else {
			whitelist = whitelist.split(',');
		}
		this.props.onSave( {
			name: this.state.group.name,
			app_whitelist: whitelist,
		} );
	}

	onCancel() {
		this.props.onCancel();
	}

	componentWillReceiveProps( nextProps: any ) {
		if ( !nextProps.group ) {
			return;
		}
		let group = Object.assign( this.state.group, nextProps.group );
		if ( Array.isArray( group.app_whitelist ) ) {
			group.app_whitelist = group.app_whitelist.join( ', ' );
		} else {
			group.app_whitelist = '';
		}
		this.setState( { group: group } );
	}

	render() {
		return <div>
			<form>
				<div style={{maxWidth: "320px"}}>
					<Flex>
						{ this.props.loadingGroup
							?	<Flex justify="flex-start">
									<span>Loading group ... </span>
									<Spinner />
								</Flex>
							:	<Flex>
								{ ( this.state?.group && typeof this.state?.group === 'object' )
									?	<Flex
											//@ts-ignore
											direction="column"
										>
											<TextControl
												label="Name"
												value={ this.state.group.name }
												onChange={ ( value: any ) => {
													const state = Object.assign( {}, this.state.group );
													state.name = value;
													this.setState( { group: state } );
												} }
											/>
											<TextareaControl
												label="App whitelist"
												help="Comma-separated values."
												value={ this.state.group.app_whitelist }
												onChange={ ( value: any ) => {
													const state = Object.assign( {}, this.state.group );
													state.app_whitelist = value;
													this.setState( { group: state } );
												} }
											/>
										</Flex>
									: 	<div style={ { opacity: 0.5 } }>Failed to fetch the group data.</div>
								}
							</Flex>
						}
					</Flex>
					<Flex justify="flex-start" style={ { marginTop: '12px' } }>
						<Button
							isPrimary
							disabled={ this.props.saving }
							onClick={ () => {
								this.onSave();
							}}
						>
							Save
						</Button>
						{this.props.saving === true &&
							<Spinner/>
						}
						<Button
							isTertiary
							onClick={ () => {
								this.onCancel();
							}}
						>
							Cancel
						</Button>
					</Flex>
				</div>
			</form>
		</div>
	}
}
