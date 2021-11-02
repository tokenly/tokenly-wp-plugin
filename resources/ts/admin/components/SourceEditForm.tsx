import * as React from 'react';
import { Component } from 'react';
import { SourceData } from '../../Interfaces';

import { 
	Button,
	Spinner,
	TextControl,
	Flex,
} from '@wordpress/components';

interface SourceEditFormProps {
	saving: boolean;
	deleting: boolean;
	onSave: any;
	onDelete: any;
	onCancel: any;
	sourceData: SourceData;
}

interface SourceEditFormState {
	source: SourceData;
}

export class SourceEditForm extends Component<SourceEditFormProps, SourceEditFormState> {
	state: SourceEditFormState = {
		source: {
			address: null,
			assets: null,
		},
	};
	constructor( props: SourceEditFormProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.onDelete = this.onDelete.bind( this );
		this.state.source = Object.assign( this.state.source, this.props.sourceData );
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

	render() {
		return <div>
			<form>
				<div style={{maxWidth: "320px"}}>
					<div>
						<TextControl
							label="Assets"
							help="Comma-separated values"
							value={ this.state.source.assets }
							onChange={ (value: any) => {
								const state = Object.assign( {}, this.state.source );
								state.assets = value;
								this.setState( { source: state } );
							} }
						/>
					</div>
					<Flex justify="flex-start" style={ { marginTop: '12px' } }>
						<Button
							isPrimary
							disabled={ this.props.saving }
							onClick={ () => {
								this.onSave();
							}}
						>
							Save address
						</Button>
						<Button
							isSecondary
							disabled={ this.props.deleting }
							onClick={ () => {
								this.onDelete();
							}}
						>
							Delete address
						</Button>
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
				</div>
			</form>
		</div>
	}
}
