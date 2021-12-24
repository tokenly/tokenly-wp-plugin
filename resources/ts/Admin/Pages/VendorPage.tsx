import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { PromiseRepositoryInterface } from '../../Interfaces/Repositories/PromiseRepositoryInterface';
import { SourceRepositoryInterface } from '../../Interfaces/Repositories/SourceRepositoryInterface';
import { PromiseData } from '../../Interfaces';
import { PromiseList } from '../Components/PromiseList';
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
	@resolve( TYPES.PromiseRepositoryInterface )
	promiseRepository: PromiseRepositoryInterface;
	@resolve( TYPES.SourceRepositoryInterface )
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
							<Flex justify="flex-start">
								<Button
									isPrimary
									isLarge
									href='/wp-admin/admin.php?page=tokenly-token-promise-store'
									style={ { marginRight: '8px' } }
								>
									Create a promise
								</Button>
								<Button
									isSecondary
									isLarge
									href='/wp-admin/admin.php?page=tokenly-token-source-index'
								>
									Manage source addresses
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel header="Current promises">
					<PanelBody>
						<PanelRow>
							<Flex>
								{ this.state.loadingPromises
								?	<Flex justify="flex-start">
										<span>Loading promises ... </span>
										<Spinner />
									</Flex>
								:	<Flex>
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
