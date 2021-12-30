import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import PromiseRepositoryInterface from '../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import SourceRepositoryInterface from '../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import { PromiseData } from '../../Interfaces';
import PromiseList from '../Components/Token/PromiseList';
import Preloader from '../Components/Preloader';
import VendorActions from '../Components/Token/VendorActions';
import { TYPES } from '../../Types';

import { 
	Button,
	Flex,
	Panel,
	PanelBody,
	PanelRow,
	Modal,
	Spinner,
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
		promises: [],
		sources: {},
		loadingPromises: true,
		loadingSources: true,
	}
	constructor( props: VendorPageProps ) {
		super( props );
		this.onDetails = this.onDetails.bind( this );
		this.onDetailsModalRequestClose = this.onDetailsModalRequestClose.bind( this );
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

	componentWillMount() {
		this.promiseRepository.index( {
			with: [ 'promise_meta.source_user', 'promise_meta.destination_user' ],
		} ).then( ( promises ) => {
			this.setState( {
				loadingPromises: false,
				promises: promises,
			} );
		} );
		this.sourceRepository.index( {
			with: [ 'address' ],
		} ).then( ( sources ) => {
			this.setState( {
				loadingSources: false,
				sources: sources,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={'Tokenpass Vendor'}>
				<Panel header="Vendor actions">
					<PanelBody>
						<PanelRow>
							<VendorActions />
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel header="Promise listing">
					<PanelBody>
						<PanelRow>
							<Flex>
								<Preloader loading={ this.state.loadingPromises } label="promises" />
							{ !this.state.loadingPromises &&
								<Flex>
									{ this.state.promises?.length > 0
										? <PromiseList
											promises={ this.state.promises }
											onDetails={ this.onDetails }
											sources={ this.state.sources }
											loadingSources={ this.state.loadingSources }
										/>
										: <div style={ { opacity: 0.5 } }>There are no registered promises</div>
									}
								</Flex>
							}
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
