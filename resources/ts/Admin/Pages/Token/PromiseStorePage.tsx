import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import PromiseRepositoryInterface from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import PromiseStoreForm from '../../Components/Token/PromiseStoreForm';
import Preloader from '../../Components/Preloader';
import ResourceStoreActions from '../../Components/ResourceStoreActions';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import { TYPES } from '../../../Types';

declare const window: any;

import { 
	Flex,
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Spinner,
} from '@wordpress/components';

interface PromiseStorePageData {
	//
}

interface PromiseStorePageProps {
	pageData: PromiseStorePageData;
}

interface PromiseStorePageState {
	isCreatePromiseModalOpen: boolean;
	loadingSources: boolean;
	storing: boolean;
	storeData: any;
	sources: any;
}

export default class PromiseStorePage extends Component<PromiseStorePageProps, PromiseStorePageState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	@resolve( TYPES.Repositories.Token.PromiseRepositoryInterface )
	promiseRepository: PromiseRepositoryInterface;
	@resolve( TYPES.Repositories.Token.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;
	
	state: PromiseStorePageState = {
		storeData: {},
		sources: null,
		loadingSources: false,
		isCreatePromiseModalOpen: false,
		storing: false,
	}
	constructor( props: PromiseStorePageProps ) {
		super( props );
		this.onCancel = this.onCancel.bind( this );
		this.onStore = this.onStore.bind( this );
		this.onStoreDataChange = this.onStoreDataChange.bind( this );
		this.isStoreDisabled = this.isStoreDisabled.bind( this );
	}
	
	return() {
		window.location = `${this.adminPageUrl}${this.namespace}-token-vendor`;
	}

	onStore() {
		this.setState( {
			storing: true,
		} );
		console.log(this.state.storeData);
		this.promiseRepository.store( this.state.storeData ).then( ( result: any ) => {
			this.setState( {
				storing: false,
			} );
			this.return();
		});
	}

	onCancel() {
		this.return();
	}

	onStoreDataChange( newData: any ) {
		this.setState( { storeData: newData } );
	}

	componentWillMount() {
		this.setState( { loadingSources: true } );
		this.sourceRepository.index( {
			with: [ 'address.balance' ],
		} ).then( ( sources: any ) => {
			this.setState( {
				loadingSources: false,
				sources: sources,
			} );
		} );
		const storeData = {
			quantity: 0,
			pseudo: false,
		}
		this.setState( { storeData: storeData } );
	}

	isStoreDisabled() {
		return (
			!this.state.storeData.source_id ||
			!this.state.storeData.asset ||
			!this.state.storeData.destination
		);
	}
	
	render() {
		return (
			<Page title="Promise Creator">
				<Panel>
				{ this.state.loadingSources &&
					<PanelHeader>
						<Preloader loading={ this.state.loadingSources }/>
					</PanelHeader>
				}
				{ !this.state.loadingSources &&
					<PanelBody>
						<PanelRow>
							<PromiseStoreForm
								onChange={ this.onStoreDataChange }
								loadingSources={ this.state.loadingSources }
								storeData={ this.state.storeData }
								sources={ this.state.sources }
							/>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceStoreActions
								name="Promise"
								storing={ this.state.storing }
								loading={ ( this.state.loadingSources ) }
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
