import * as React from 'react';
import { Component } from 'react';

import { 
	Button,
	Spinner,
	TextareaControl,
	Flex,
} from '@wordpress/components';

interface SourceEditFormProps {
	saving: boolean;
	deleting: boolean;
	loading?: boolean;
	onSave: any;
	onDelete: any;
	onCancel: any;
	source: any;
}

interface SourceEditFormState {
	source: any;
}

export default class SourceEditForm extends Component<SourceEditFormProps, SourceEditFormState> {
	state: SourceEditFormState = {
		source: null,
	};
	constructor( props: SourceEditFormProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.onDelete = this.onDelete.bind( this );
	}
	
	onSave() {
		this.props.onSave( this.state.source );
	}

	onDelete() {
		this.props.onDelete();
	}

	onCancel() {
		this.props.onCancel();
	}

	componentWillReceiveProps( nextProps: any ) {
		if ( !nextProps.source ) {
			return;
		}
		let source = Object.assign( {}, nextProps.source );
		this.setState( { source: source } );
	}

	render() {
		return <div>
			<form>
			{ this.props.loading
			?	<Flex justify="flex-start">
					<span>Loading source ... </span>
					<Spinner />
				</Flex>
			:	<Flex style={{maxWidth: "320px"}}>
					<Flex>
						<TextareaControl
							label="Whitelisted assets"
							help="Comma-separated values. Assets which are allowed for making promises."
							value={ this.state.source.assets }
							onChange={ (value: any) => {
								const state = Object.assign( {}, this.state.source );
								state.assets = value;
								this.setState( { source: state } );
							} }
						/>
					</Flex>
				</Flex>
			}
				<Flex justify="flex-start" style={ { marginTop: '12px' } }>
					<Button
						isPrimary
						disabled={ this.props.saving }
						onClick={ () => {
							this.onSave();
						}}
					>
						{ this.props.saving ? 'Saving ...' : 'Save source' }
					</Button>
					{this.props.saving === true &&
						<Spinner/>
					}
					<Button
						isSecondary
						disabled={ this.props.deleting }
						onClick={ () => {
							this.onDelete();
						}}
					>
						{ this.props.deleting ? 'Deleting ...' : 'Delete source' }
					</Button>
					{this.props.deleting === true &&
						<Spinner/>
					}
					<Button
						isTertiary
						disabled={ this.props.deleting }
						onClick={ () => {
							this.onCancel();
						}}
					>
						Cancel
					</Button>
				</Flex>
			</form>
		</div>
	}
}
