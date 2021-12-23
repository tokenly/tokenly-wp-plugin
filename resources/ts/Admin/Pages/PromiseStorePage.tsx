import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { PromiseRepositoryInterface } from '../../Interfaces/Repositories/PromiseRepositoryInterface';
import { PromiseStoreForm } from '../Components/PromiseStoreForm';
import { PromiseData, PromiseStoreParams, SourceItem } from '../../Interfaces';
import { TYPES } from '../../Types';

declare const window: any;

import { 
	Button,
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Modal,
} from '@wordpress/components';

interface PromiseStorePageData {
	sources: Array<SourceItem>;
}

interface PromiseStorePageProps {
	pageData: PromiseStorePageData;
	saving: boolean;
}

interface PromiseStorePageState {
	promiseData: Array<PromiseData>;
	isCreatePromiseModalOpen: boolean;
	storingPromise: boolean;
}

export default class PromiseStorePage extends Component<PromiseStorePageProps, PromiseStorePageState> {
	@resolve( TYPES.PromiseRepositoryInterface )
	promiseRepository: PromiseRepositoryInterface;
	
	state: PromiseStorePageState = {
		promiseData: [],
		isCreatePromiseModalOpen: false,
		storingPromise: false,
	}
	constructor( props: PromiseStorePageProps ) {
		super( props );
		this.onSubmit = this.onSubmit.bind( this );
	}
	
	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-token-vendor';
	}

	onSubmit( params: PromiseStoreParams ) {
		this.setState( {
			storingPromise: true,
		} );
		this.promiseRepository.store( params ).then( result => {
			this.setState( {
				storingPromise: false,
			} );
			this.return();
		});
	}

	onCancel() {
		this.return();
	}
	
	render() {
		return (
			<Page title={'Create a token promise'}>
				<div style={ { marginBottom: '8px' } }>
					<a style={ { display: 'inline-block' } } href='/wp-admin/admin.php?page=tokenly-token-vendor'>Back to vendor</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<PromiseStoreForm
								onSubmit={ this.onSubmit }
								onCancel={ this.onCancel }
								saving={ this.state.storingPromise }
								style={ { marginBottom: '12px' } }
								sources={ this.props.pageData.sources }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
