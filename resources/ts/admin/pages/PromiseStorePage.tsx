import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { PromiseRepository } from '../../repositories/PromiseRepository';
import { PromiseStoreForm } from '../components/PromiseStoreForm';
import { PromiseData, PromiseStoreParams } from '../../interfaces';

declare const window: any;

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Modal,
} from '@wordpress/components';

interface PromiseStorePageData {
	//
}

interface PromiseStorePageProps {
	pageData: PromiseStorePageData;
	saving: boolean;
}

interface User {
	name: string;
	id: number;
}

interface PromiseStorePageState {
	promiseData: Array<PromiseData>;
	isCreatePromiseModalOpen: boolean;
	storingPromise: boolean;
}

export default class PromiseStorePage extends Component<PromiseStorePageProps, PromiseStorePageState> {
	@resolve
	promiseRepository: PromiseRepository;
	
	state: PromiseStorePageState = {
		promiseData: [],
		isCreatePromiseModalOpen: false,
		storingPromise: false,
	}
	constructor( props: PromiseStorePageProps ) {
		super( props );
		this.onPromiseSubmit = this.onPromiseSubmit.bind( this );
	}
	
	componentDidMount() {
		this.promiseRepository.index().then( ( promiseData: Array<PromiseData> ) => {
			this.setState( {
				promiseData: promiseData,
			} );
		} );
	}
	
	onPromiseSubmit( params: PromiseStoreParams ) {
		this.promiseRepository.store( params ).then( result => {
			window.location = '/wp-admin/admin.php?page=tokenpass-vendor';
		});
	}
	
	render() {
		return (
			<Page title={'Create token promise'}>
				<Panel>
					<PanelBody>
						<PanelRow>
							<PromiseStoreForm
								onSubmit={ this.onPromiseSubmit }
								saving={ this.state.storingPromise }
								style={ { marginBottom: '12px' } }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
