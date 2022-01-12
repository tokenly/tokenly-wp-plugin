import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import PromiseRepositoryInterface from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import { PromiseData } from '../../../Interfaces';
import PromiseList from '../../Components/Token/PromiseList';
import Preloader from '../../Components/Preloader';
import VendorActions from '../../Components/Token/VendorActions';
import { TYPES } from '../../../Types';

import { 
	Flex,
	Panel,
	PanelBody,
	PanelHeader,
	PanelRow,
} from '@wordpress/components';

interface VendorPageData {
	promises: Array<PromiseData>;
	sources: any;
}

interface VendorPageProps {
	pageData: VendorPageData;
	saving: boolean;
}

interface VendorPageState {
	promiseData: Array<PromiseData>;
	isPromiseDetailsModalOpen: boolean;
	storingPromise: boolean;
	currentPromise: number;
	promises: any;
	sources: any;
	loadingPromises: boolean;
	loadingSources: boolean;
}

export default class VendorPage extends Component<VendorPageProps, VendorPageState> {
	@resolve( TYPES.Repositories.Token.PromiseRepositoryInterface )
	promiseRepository: PromiseRepositoryInterface;
	@resolve( TYPES.Repositories.Token.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;
	
	state: VendorPageState = {
		promiseData: [],
		isPromiseDetailsModalOpen: false,
		storingPromise: false,
		currentPromise: 0,
		promises: null,
		sources: {},
		loadingPromises: false,
		loadingSources: false,
	}
	constructor( props: VendorPageProps ) {
		super( props );
		this.onDetails = this.onDetails.bind( this );
		this.onDetailsModalRequestClose = this.onDetailsModalRequestClose.bind( this );
		this.getLoadingLabel = this.getLoadingLabel.bind( this );
		this.getLoadingState = this.getLoadingState.bind( this );
	}

	onDetailsModalRequestClose() {
		this.setState( {
			isPromiseDetailsModalOpen: false,
		} );
	}

	onDetails( index: number) {
		this.setState( {
			currentPromise: index,
			isPromiseDetailsModalOpen: true,
		} );
	}

	getLoadingState() {
		return ( 
			this.state.loadingPromises ||
			this.state.loadingSources
		);
	}
	
	getLoadingLabel() {
		if ( this.state.loadingPromises ) {
			return 'promises';
		} else if ( this.state.loadingSources ) {
			return 'sources';
		}
	}

	componentWillMount() {
		this.setState( { loadingPromises: true } );
		this.promiseRepository.index( {
			with: [ 'promise_meta.source_user', 'promise_meta.destination_user' ],
		} ).then( ( promises ) => {
			this.setState( {
				loadingPromises: false,
				loadingSources: true,
				promises: promises,
			} );
			this.sourceRepository.index( {
				with: [ 'address' ],
			} ).then( ( sources ) => {
				const promises = this.state.promises.map( ( promise: any ) => {
					promise.source = sources[ promise.source_id ];
					return promise;
				} );
				this.setState( {
					loadingSources: false,
					promises: promises,
					sources: sources,
				} );
			} );
		} );
	}
	
	render() {
		const loading = this.getLoadingState();
		return (
			<Page title="Token Vendor">
				<Panel header="Vendor Actions">
					<PanelBody>
						<PanelRow>
							<VendorActions />
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelHeader>
						<Preloader loading={ loading }>Registered Promises</Preloader>
					</PanelHeader>
				{ ( !loading || this.state.promises ) &&
					<PanelBody>
						<PanelRow>
							<Flex>
								{ this.state.promises?.length > 0
									? 	<PromiseList
											promises={ this.state.promises }
										/>
									: 	<div style={ { opacity: 0.5 } }>There are no registered promises</div>
								}
							</Flex>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
			</Page>
		);
	}
}
