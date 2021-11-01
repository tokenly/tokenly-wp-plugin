import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { PromiseRepository } from '../../repositories/PromiseRepository';
import { PromiseData } from '../../interfaces';
import { PromiseList } from '../components/PromiseList';

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
									href='/wp-admin/admin.php?page=tokenpass-promise-store'
									style={ { marginRight: '8px' } }
								>
									Create a promise
								</Button>
								<Button
									isSecondary
									isLarge
									href='/wp-admin/admin.php?page=tokenpass-source-index'
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
							<PromiseList promises={this.props.pageData.promises} />
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
