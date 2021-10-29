import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { PromiseRepository } from '../../repositories/PromiseRepository';
import { PromiseData, PromiseStoreParams } from '../../interfaces';
import { PromiseStoreForm } from '../components/PromiseStoreForm';

import { 
	Button,
	ButtonGroup,
	Panel,
	PanelBody,
	PanelRow,
	Modal,
} from '@wordpress/components';

interface VendorPageData {
	//
}

interface VendorPageProps {
	pageData: VendorPageData;
	saving: boolean;
}

interface VendorPageState {
	promiseData: Array<PromiseData>;
	isCreatePromiseModalOpen: boolean;
	storingPromise: boolean;
}

export default class VendorPage extends Component<VendorPageProps, VendorPageState> {
	@resolve
	promiseRepository: PromiseRepository;
	
	state: VendorPageState = {
		promiseData: [],
		isCreatePromiseModalOpen: false,
		storingPromise: false,
	}
	constructor( props: VendorPageProps ) {
		super( props );
	}
	
	componentDidMount() {
		this.promiseRepository.index().then( ( promiseData: Array<PromiseData> ) => {
			this.setState( {
				promiseData: promiseData,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={'Tokenpass Vendor'}>
				<Panel header="Token promises">
					<PanelBody>
						<PanelRow>
							<ButtonGroup>
								<Button
									isPrimary
									isLarge
									href='/wp-admin/admin.php?page=tokenpass-promise-store'
									style={ { marginRight: '8px' } }
								>
									Create token promise
								</Button>
								<Button
									isPrimary
									isLarge
									href='/wp-admin/admin.php?page=tokenpass-source-index'
								>
									Manage source addresses
								</Button>
							</ButtonGroup>
						</PanelRow>
						<PanelRow>
							<div>
								<div>Current promises:</div>
							</div>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
