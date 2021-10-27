import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { PromiseRepository, PromiseData, PromiseStoreData } from '../../repositories/PromiseRepository';
import { PromiseStoreForm } from '../components/PromiseStoreForm';

declare const wp: any;

const { __ } = wp.i18n;

const {
	Button,
	ButtonGroup,
	Panel,
	PanelBody,
	PanelRow,
	Modal,
} = wp.components;

interface VendorPageData {
	//
}

interface VendorPageProps {
	pageData: VendorPageData;
	saving: boolean;
}

interface User {
	name: string;
	id: number;
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
									text='Create token promise'
									isPrimary
									isLarge
									href='/wp-admin/admin.php?page=tokenpass-promise-store'
									style={ { marginRight: '8px' } }
								/>
								<Button
									text='Manage source addresses'
									isPrimary
									isLarge
									href='/wp-admin/admin.php?page=tokenpass-source-index'
								/>
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