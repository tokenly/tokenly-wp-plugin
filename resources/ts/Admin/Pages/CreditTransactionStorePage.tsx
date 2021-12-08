import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { CreditTransactionRepositoryInterface } from '../../Interfaces/Repositories/CreditTransactionRepositoryInterface';
import { CreditTransactionStoreForm } from '../Components/CreditTransactionStoreForm';
import { TYPES } from '../../Types';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface CreditTransactionStorePageData {
	credit_groups: any;
}

interface CreditTransactionStorePageProps {
	pageData: CreditTransactionStorePageData;
	saving: boolean;
}

interface CreditTransactionStorePageState {
	storingCreditTransaction: boolean;
	address: any;
}

export default class CreditTransactionStorePage extends Component<CreditTransactionStorePageProps, CreditTransactionStorePageState> {
	@resolve( TYPES.CreditTransactionRepositoryInterface )
	creditGroupRepository: CreditTransactionRepositoryInterface;
	
	state: CreditTransactionStorePageState = {
		storingCreditTransaction: false,
		address: null,
	}
	constructor( props: CreditTransactionStorePageProps ) {
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
			<Page title={'Make App Credits transaction'}>
				<div style={ { marginBottom: '8px' } }>
					<a href='/wp-admin/admin.php?page=tokenly-credit-group-index'>Back to credit group list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<CreditTransactionStoreForm
								onSubmit={ this.onSubmit }
								onCancel={ this.return }
								saving={ this.state.storingCreditTransaction }
								style={ { marginBottom: '12px' } }
								creditGroups={ this.props.pageData.credit_groups }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
