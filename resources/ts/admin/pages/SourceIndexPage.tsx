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
} from '@wordpress/components';

interface SourceIndexPageData {
	//
}

interface SourceIndexPageProps {
	pageData: SourceIndexPageData;
	saving: boolean;
}

interface User {
	name: string;
	id: number;
}

interface SourceIndexPageState {
	promiseData: Array<PromiseData>;
	isCreatePromiseModalOpen: boolean;
	storingPromise: boolean;
}

export default class SourceIndexPage extends Component<SourceIndexPageProps, SourceIndexPageState> {
	@resolve
	promiseRepository: PromiseRepository;
	
	state: SourceIndexPageState = {
		promiseData: [],
		isCreatePromiseModalOpen: false,
		storingPromise: false,
	}
	constructor( props: SourceIndexPageProps ) {
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
							<Button
								isPrimary
								isLarge
								href='/wp-admin/admin.php?page=tokenpass-source-store'
							>Register source address</Button>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
