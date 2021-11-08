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
		this.onCancel = this.onCancel.bind( this );
	}
	
	return() {
		window.location = '/wp-admin/admin.php?page=tokenpass-vendor';
	}

	onSubmit( params: PromiseStoreParams ) {
		this.promiseRepository.store( params ).then( result => {
			this.return();
		});
	}

	onCancel() {
		this.return();
	}
	
	render() {
		const sources = Object.keys( this.props.pageData.sources ).map( ( key: any ) => this.props.pageData.sources[key] ) as any;
		sources.push( 
			{
				label: null,
				value: null,
			},
		);
		return (
			<Page title={'Create token promise'}>
				<div style={{marginBottom: '8px'}}>
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenpass-vendor'>Back to vendor</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<PromiseStoreForm
								onSubmit={ this.onSubmit }
								onCancel={ this.onCancel }
								saving={ this.state.storingPromise }
								style={ { marginBottom: '12px' } }
								sources={ sources }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
