import * as React from 'react';
import { Component } from 'react';
import { SourceData } from '../../interfaces';

import { 
	Button,
	Spinner,
	TextControl,
} from '@wordpress/components';

interface SourceStoreFormProps {
	saving: boolean;
	onSubmit: any;
	style: any;
}

interface SourceStoreFormState {
	store: SourceData;
}

export class SourceStoreForm extends Component<SourceStoreFormProps, SourceStoreFormState> {
	state: SourceStoreFormState = {
		store: {
			address: null,
			assets: null,
		},
	};
	constructor( props: SourceStoreFormProps ) {
		super( props );
		this.onSourceSubmit = this.onSourceSubmit.bind( this );
	}
	
	onSourceSubmit() {
		this.props.onSubmit( this.state.store );
	}

	render() {
		return <div>
			<form>
				<div style={{maxWidth: "320px"}}>
					<TextControl
						label="Address"
						value={ this.state.store.address }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.store );
							state.address = value;
							this.setState( { store: state } );
						} }
					/>
					<TextControl
						label="Assets"
						// @ts-ignore
						hint="Comma-separated values"
						value={ this.state.store.assets }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.store );
							state.assets = value;
							this.setState( { store: state } );
						} }
					/>
					<Button
						isPrimary
						isLarge
						disabled={ this.props.saving }
						onClick={ () => {
							this.onSourceSubmit();
						}}
						style={ { marginTop: '12px' } }
					>
						Register address
					</Button>
					{this.props.saving === true &&
						<Spinner/>
					}
				</div>
			</form>
		</div>
	}
}
