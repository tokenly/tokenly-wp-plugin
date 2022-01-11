import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import { TYPES } from '../../../Types';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import SourceStoreForm from '../../Components/Token/SourceStoreForm';
import ResourceStoreActions from '../../Components/ResourceStoreActions';
import Preloader from '../../Components/Preloader';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface SourceStorePageData {
	//
}

interface SourceStorePageProps {
	pageData: SourceStorePageData;
}

interface SourceStorePageState {
	storing: boolean;
	loadingAddresses: boolean;
	address: any;
	addresses: any;
	storeData: any;
}

export default class SourceStorePage extends Component<SourceStorePageProps, SourceStorePageState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	@resolve( TYPES.Repositories.Token.AddressRepositoryInterface )
	addressRepository: AddressRepositoryInterface;
	@resolve( TYPES.Repositories.Token.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;
	
	state: SourceStorePageState = {
		storing: false,
		loadingAddresses: false,
		address: null,
		addresses: null,
		storeData: {},
	}
	constructor( props: SourceStorePageProps ) {
		super( props );
		this.onStore = this.onStore.bind( this );
		this.onStoreDataChange = this.onStoreDataChange.bind( this );
		this.onCancel = this.onCancel.bind( this );
	}

	return() {
		window.location = `${this.adminPageUrl}${this.namespace}-token-source-index`;
	}

	componentWillMount() {
		this.setState( { loadingAddresses: true } );
		const params = {
			id: 'me',
			registered: true,
		}
		this.addressRepository.index( params ).then( ( addresses: any ) => {
			this.setState( {
				loadingAddresses: false,
				addresses: addresses,
			} );
		} );
	}

	onStore() {
		const selectedAddress = this.state.addresses[this.state.storeData?.address];
		if ( !selectedAddress ) {
			return;
		}
		const storeData = Object.assign( {}, this.state.storeData );
		storeData.type = this.state.addresses[this.state.storeData.address].type;	
		this.setState( { storing: true } );
		this.sourceRepository.store( storeData ).then( ( result: any ) => {
			this.setState( { storing: false } );
			this.return();
		});
	}
	
	onStoreDataChange( newData: any ) {
		this.setState( { storeData: newData } );
	}

	onCancel() {
		this.return();
	}

	isStoreDisabled() {
		return false;
	}
	
	render() {
		return (
			<Page title="Source Creator">
				<Panel>
				{ this.state.loadingAddresses &&
					<PanelHeader>
						<Preloader loading={ this.state.loadingAddresses } />
					</PanelHeader>
				}
				{ !this.state.loadingAddresses &&
					<PanelBody>
						<PanelRow>
							<SourceStoreForm
								onChange={ this.onStoreDataChange }
								loadingAddresses={ this.state.loadingAddresses }
								addresses={ this.state.addresses }
								storeData={ this.state.storeData }
							/>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceStoreActions
								name="Source"
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
