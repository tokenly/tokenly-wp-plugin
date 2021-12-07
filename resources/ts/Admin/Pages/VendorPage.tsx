import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { PromiseRepositoryInterface } from '../../Interfaces/Repositories/PromiseRepositoryInterface';
import { PromiseData } from '../../Interfaces';
import { PromiseList } from '../Components/PromiseList';
import { PromiseDetailsModal } from '../Components/PromiseDetailsModal';
import { TYPES } from '../../Types';

import { 
	Button,
	Flex,
	Panel,
	PanelBody,
	PanelRow,
	Modal,
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
}

export default class VendorPage extends Component<VendorPageProps, VendorPageState> {
	@resolve( TYPES.PromiseRepositoryInterface )
	promiseRepository: PromiseRepositoryInterface;
	
	state: VendorPageState = {
		promiseData: [],
		isPromiseDetailsModalOpen: false,
		storingPromise: false,
		currentPromise: 0,
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
	
	render() {
		return (
			<Page title={'Tokenpass Vendor'}>
				{this.state.isPromiseDetailsModalOpen &&
					<PromiseDetailsModal
						onRequestClose={this.onDetailsModalRequestClose}
						promise={this.props.pageData.promises[ this.state.currentPromise ]}
					/>
				}
				<Panel header="Vendor actions">
					<PanelBody>
						<PanelRow>
							<Flex justify="flex-start">
								<Button
									isPrimary
									isLarge
									href='/wp-admin/admin.php?page=tokenly-promise-store'
									style={ { marginRight: '8px' } }
								>
									Create a promise
								</Button>
								<Button
									isSecondary
									isLarge
									href='/wp-admin/admin.php?page=tokenly-source-index'
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
							{ this.props.pageData?.promises?.length > 0
								? <PromiseList
									promises={ this.props.pageData.promises }
									onDetails={ this.onDetails }
									sources={ this.props.pageData.sources }
								/>
								: <div style={ { opacity: 0.5 } }>There are no registered promises</div>
							}
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
