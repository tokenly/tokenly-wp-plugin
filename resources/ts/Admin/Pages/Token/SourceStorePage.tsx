import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import SourceStoreForm from '../../Components/Token/SourceStoreForm';
import { SourceData } from '../../../Interfaces';
import { TYPES } from '../../../Types';

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
		this.onSubmit = this.onSubmit.bind( this );
		this.onStoreDataChange = this.onStoreDataChange.bind( this );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-token-source-index';
	}
	
	onSubmit() {
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
	
	render() {
		return (
			<Page title={'Register source address'}>
				<Panel>
					<PanelBody>
						<PanelRow>
							<SourceStoreForm
								onSubmit={ this.onSubmit }
								onChange={ this.onStoreDataChange }
								onCancel={ this.return }
								loadingAddresses={ this.state.loadingAddresses }
								storing={ this.state.storing }
								style={ { marginBottom: '12px' } }
								addresses={ this.state.addresses }
								storeData={ this.state.storeData }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
