import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import TransactionRepositoryInterface from '../../../Interfaces/Repositories/Credit/TransactionRepositoryInterface';
import TransactionStoreForm from '../../Components/Credit/TransactionStoreForm';
import { TYPES } from '../../../Types';
import ResourceStoreActions from '../../Components/ResourceStoreActions';
import Preloader from '../../Components/Preloader';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';


interface TransactionStorePageData {
	//
}

interface TransactionStorePageProps {
	pageData: TransactionStorePageData;
	saving: boolean;
}

interface TransactionStorePageState {
	storing: boolean;
	loadingGroups: boolean;
	groups: any;
	storeData: any;
}

export default class TransactionStorePage extends Component<TransactionStorePageProps, TransactionStorePageState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;
	@resolve( TYPES.Repositories.Credit.TransactionRepositoryInterface )
	transactionRepository: TransactionRepositoryInterface;
	
	state: TransactionStorePageState = {
		storing: false,
		loadingGroups: false,
		groups: null,
		storeData: {},
	}
	constructor( props: TransactionStorePageProps ) {
		super( props );
		this.onCancel = this.onCancel.bind( this );
		this.onStore = this.onStore.bind( this );
		this.onStoreDataChange = this.onStoreDataChange.bind( this );
		this.isStoreDisabled = this.isStoreDisabled.bind( this );
	}

	return() {
		window.location = `${this.adminPageUrl}${this.namespace}-credit-group-index`;
	}

	componentWillMount() {
		this.setState( { loadingGroups: true } );
		this.groupRepository.index().then( ( groups: any ) => {
			const storeData = {
				quantity: 0,
				pseudo: false,
				type: 'credit',
			}
			this.setState( {
				loadingGroups: false,
				groups: groups,
				storeData: storeData,
			} );
		} );
	}

	isStoreDisabled() {
		return false;
	}

	onStore() {
		this.setState( { storing: true } );
		this.transactionRepository.store( this.state.storeData ).then( ( result: any ) => {
			this.setState( { storing: false } );
			this.return();
		});
	}

	onCancel() {
		this.return();
	}

	onStoreDataChange( newData: any ) {
		this.setState( { storeData: newData } );
	}
	
	render() {
		return (
			<Page title="Transaction Creator">
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loadingGroups }>Transaction form</Preloader>
					</PanelHeader>
				{ ( !this.state.loadingGroups && this.state.groups ) &&
					<PanelBody>
						<PanelRow>
							<TransactionStoreForm
								storeData={ this.state.storeData }
								groups={ this.state.groups }
								onChange={ this.onStoreDataChange }
								loadingGroups={ this.state.loadingGroups }
							/>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceStoreActions
								name="Transaction"
								storing={ this.state.storing }
								onStore={ this.onStore }
								onCancel={ this.onCancel }
								disableStore={ this.isStoreDisabled() }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
