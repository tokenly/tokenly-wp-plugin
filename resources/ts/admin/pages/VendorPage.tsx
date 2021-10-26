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
		this.openCreatePromiseModal = this.openCreatePromiseModal.bind( this );
		this.closeCreatePromiseModal = this.closeCreatePromiseModal.bind( this );
	}
	
	componentDidMount() {
		this.promiseRepository.index().then( ( promiseData: Array<PromiseData> ) => {
			this.setState( {
				promiseData: promiseData,
			} );
		} );
	}
	
	onUserSearch( keywords: string ) {
		
	}
	
	onUserSelect( username: string ) {
		
	}
	
	onPromiseSubmit( promise: PromiseStoreData ) {
		
	}
	
	openCreatePromiseModal() {
		this.setState( { isCreatePromiseModalOpen: true } );
	}
	
	closeCreatePromiseModal() {
		this.setState( { isCreatePromiseModalOpen: false } );
	}
	
	render() {
		return (
			<Page title={'Tokenpass Vendor'}>
				<Panel header="Token promises">
					<PanelBody>
						<PanelRow>
							<Button 
								isPrimary
								isLarge
								onClick={ this.openCreatePromiseModal }
							>
								Create token promise
							</Button>
							{ this.state.isCreatePromiseModalOpen && (
								<Modal title="Create token promise" onRequestClose={ this.closeCreatePromiseModal }>
									<PromiseStoreForm onSubmit={ this.onPromiseSubmit } saving={ this.state.storingPromise } />
								</Modal>
							) }
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
