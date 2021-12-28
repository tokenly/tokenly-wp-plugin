import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import PromiseEditForm from '../../Components/Token/PromiseEditForm';
import { PromiseData, PromiseUpdateParams } from '../../../Interfaces';
import eventBus from "../../../EventBus";
import PromiseRepositoryInterface from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import { TYPES } from '../../../Types';

import { 
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	Spinner,
} from '@wordpress/components';

declare const window: any;

interface PromiseEditPageData {
	promise: PromiseData;
}

interface PromiseEditPageProps {
	pageData: PromiseEditPageData;
}

interface PromiseEditPageState {
	saving: boolean;
	deleting: boolean;
	loading: boolean;
	promise: any;
	promiseId: number;
}

export default class PromiseEditPage extends Component<PromiseEditPageProps, PromiseEditPageState> {
	@resolve( TYPES.Repositories.Token.PromiseRepositoryInterface )
	promiseRepository: PromiseRepositoryInterface;
	
	state: PromiseEditPageState = {
		saving: false,
		deleting: false,
		loading: false,
		promise: null,
		promiseId: null,
	}

	constructor( props: PromiseEditPageProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.onDelete = this.onDelete.bind( this );
		this.deletePromise = this.deletePromise.bind( this );
		this.onConfirmModalChoice = this.onConfirmModalChoice.bind( this );
		this.onCancel = this.onCancel.bind( this );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.promiseId = parseInt( urlParams.get( 'promise' ) );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-token-vendor';
	}

	onSave( promise: PromiseUpdateParams ) {
		this.setState( { saving: true } );
		this.promiseRepository.update( this.state.promiseId, promise ).then( ( result: any ) => {
			this.setState( { saving: false } );
			this.return();
		});
	}

	onDelete() {
		eventBus.dispatch( 'confirmModalShow', {
			key: 'promiseDelete',
			title: 'Deleting promise',
			subtitle: 'Are you sure you want to delete the promise?',
		});
	}

	deletePromise() {
		this.setState( { deleting: true } );
		this.promiseRepository.destroy( this.state.promiseId ).then( ( result: any ) => {
			this.setState( { deleting: false } );
			this.return();
		});
	}

	onConfirmModalChoice( payload: any ) {
		switch( payload.key ) {
			case 'promiseDelete':
				if ( payload.choice == 'accept' ){
					this.deletePromise();
				}
				break;
		}
	}

	componentDidMount() {
		eventBus.on( 'confirmModalChoice', this.onConfirmModalChoice );
	}
	
	componentWillUnmount() {
		eventBus.remove( 'confirmModalChoice', this.onConfirmModalChoice );
	}

	onCancel() {
		this.return();
	}
	
	componentWillMount() {
		this.setState( { loading: true } );
		this.promiseRepository.show( this.state.promiseId ).then( ( promise: any ) => {
			this.setState( {
				loading: false,
				promise: promise,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={ 'Promise editor' }>
				<div style={ { marginBottom: '8px' } }>
					<a style={ { display: 'inline-block' } } href='/wp-admin/admin.php?page=tokenly-token-vendor'>Back to vendor</a>
					<div><span>Promise ID: </span><strong>{ this.state.promiseId }</strong></div>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<PromiseEditForm
								onSave={ this.onSave }
								onDelete={ this.onDelete }
								onCancel={ this.onCancel }
								loading={ this.state.loading }
								saving={this.state.saving}
								deleting={this.state.deleting}
								promise={this.state?.promise}
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
