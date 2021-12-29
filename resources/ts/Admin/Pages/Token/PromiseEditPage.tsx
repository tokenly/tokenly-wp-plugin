import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import PromiseEditForm from '../../Components/Token/PromiseEditForm';
import ResourceEditActions from '../../Components/ResourceEditActions';
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
	PanelHeader,
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
	id: number;
	editData: any;
}

export default class PromiseEditPage extends Component<PromiseEditPageProps, PromiseEditPageState> {
	@resolve( TYPES.Repositories.Token.PromiseRepositoryInterface )
	promiseRepository: PromiseRepositoryInterface;
	
	state: PromiseEditPageState = {
		saving: false,
		deleting: false,
		loading: false,
		promise: null,
		id: null,
		editData: {},
	}

	constructor( props: PromiseEditPageProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.onDelete = this.onDelete.bind( this );
		this.deletePromise = this.deletePromise.bind( this );
		this.onConfirmModalChoice = this.onConfirmModalChoice.bind( this );
		this.onEditDataChange = this.onEditDataChange.bind( this );
		this.onCancel = this.onCancel.bind( this );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = parseInt( urlParams.get( 'promise' ) );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-token-vendor';
	}

	onSave() {
		this.setState( { saving: true } );
		this.promiseRepository.update( this.state.id, this.state.editData ).then( ( result: any ) => {
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
		this.promiseRepository.destroy( this.state.id ).then( ( result: any ) => {
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
		this.promiseRepository.show( this.state.id ).then( ( promise: any ) => {
			const editData = {
				quantity: promise?.quantity?.value_sat,
				expiration: null,
				txid: null,
				fingerprint: null,
				ref: promise.ref,
				note: promise.note,
			} as any;
			this.setState( {
				loading: false,
				promise: promise,
				editData: editData,
			} );
		} );
	}

	onEditDataChange( newData: any ) {
		this.setState( { editData: newData } );
	}
	
	render() {
		return (
			<Page title={ 'Promise editor' }>
				<Panel>
					<PanelHeader>
						{ this.state.loading
						?	<Flex justify="flex-start">
								<span>Loading promise ... </span>
								<Spinner />
							</Flex>
						:	<a href={ `/wp-admin/admin.php?page=tokenly-token-promise-show&promise=${ this.state.id }` }>{ `Promise № ${this.state.id}` }</a>
						}
					</PanelHeader>
					<PanelBody>
						<PanelRow>
							<Flex
								//@ts-ignore
								direction="column"
							>
							{ !this.state.loading &&
								<PromiseEditForm
									onChange={ this.onEditDataChange }
									loading={ this.state.loading }
									editData={this.state?.editData}
								/>
							}
								<ResourceEditActions
									name="promise"
									loading={ this.state.loading }
									saving={ this.state.saving }
									deleting={ this.state.deleting }
									onSave={ this.onSave }
									onDelete={ this.onDelete }
									onCancel={ this.onCancel }
								/>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
