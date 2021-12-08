import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SourceRepositoryInterface } from '../../Interfaces/Repositories/SourceRepositoryInterface';
import { SourceStoreForm } from '../Components/SourceStoreForm';
import { SourceData } from '../../Interfaces';
import { TYPES } from '../../Types';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface SourceStorePageData {
	addresses: Array<any>;
}

interface SourceStorePageProps {
	pageData: SourceStorePageData;
	saving: boolean;
}

interface SourceStorePageState {
	storingSource: boolean;
	address: any;
}

export default class SourceStorePage extends Component<SourceStorePageProps, SourceStorePageState> {
	@resolve( TYPES.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;
	
	state: SourceStorePageState = {
		storingSource: false,
		address: null,
	}
	constructor( props: SourceStorePageProps ) {
		super( props );
		this.onSubmit = this.onSubmit.bind( this );
		this.onAddressChange = this.onAddressChange.bind( this );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-source-index';
	}
	
	onSubmit( promise: SourceData ) {
		this.sourceRepository.store( promise ).then( ( result: any ) => {
			this.return();
		});
	}
	
	onAddressChange( address: any ) {
		this.setState( { address: address } );
	}
	
	render() {
		return (
			<Page title={'Register source address'}>
				<div style={ { marginBottom: '8px' } }>
					<a href='/wp-admin/admin.php?page=tokenly-source-index'>Back to source address list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<SourceStoreForm
								onSubmit={ this.onSubmit }
								onChange={ this.onAddressChange }
								onCancel={ this.return }
								saving={ this.state.storingSource }
								style={ { marginBottom: '12px' } }
								addresses={ this.props.pageData.addresses }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
