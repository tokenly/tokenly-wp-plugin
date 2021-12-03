import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { CreditGroupRepositoryInterface } from '../../Interfaces/Repositories/CreditGroupRepositoryInterface';
import { CreditGroupStoreForm } from '../Components/CreditGroupStoreForm';
import { SourceData } from '../../Interfaces';
import { TYPES } from '../../Types';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface CreditGroupStorePageData {
	addresses: Array<any>;
}

interface CreditGroupStorePageProps {
	pageData: CreditGroupStorePageData;
	saving: boolean;
}

interface CreditGroupStorePageState {
	storingCreditGroup: boolean;
	address: any;
}

export default class CreditGroupStorePage extends Component<CreditGroupStorePageProps, CreditGroupStorePageState> {
	@resolve( TYPES.CreditGroupRepositoryInterface )
	creditGroupRepository: CreditGroupRepositoryInterface;
	
	state: CreditGroupStorePageState = {
		storingCreditGroup: false,
		address: null,
	}
	constructor( props: CreditGroupStorePageProps ) {
		super( props );
		this.onSubmit = this.onSubmit.bind( this );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-credit-group-index';
	}
	
	onSubmit( creditGroup: any ) {
		this.creditGroupRepository.store( creditGroup ).then( ( result: any ) => {
			this.return();
		});
	}
	
	render() {
		return (
			<Page title={'Register credit group'}>
				<div style={ { marginBottom: '8px' } }>
					<a href='/wp-admin/admin.php?page=tokenly-credit-group-index'>Back to credit group list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<CreditGroupStoreForm
								onSubmit={ this.onSubmit }
								onCancel={ this.return }
								saving={ this.state.storingCreditGroup }
								style={ { marginBottom: '12px' } }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
