import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import TransactionRepositoryInterface from '../../../Interfaces/Repositories/Credit/TransactionRepositoryInterface';
import TransactionStoreForm from '../../Components/Credit/TransactionStoreForm';
import { TYPES } from '../../../Types';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface TransactionStorePageData {
	credit_groups: any;
}

interface TransactionStorePageProps {
	pageData: TransactionStorePageData;
	saving: boolean;
}

interface TransactionStorePageState {
	storingCreditTransaction: boolean;
	address: any;
}

export default class TransactionStorePage extends Component<TransactionStorePageProps, TransactionStorePageState> {
	@resolve( TYPES.Repositories.Credit.TransactionRepositoryInterface )
	transactionRepository: TransactionRepositoryInterface;
	
	state: TransactionStorePageState = {
		storingCreditTransaction: false,
		address: null,
	}
	constructor( props: TransactionStorePageProps ) {
		super( props );
		this.onSubmit = this.onSubmit.bind( this );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-credit-group-index';
	}
	
	onSubmit( creditGroup: any ) {
		this.setState( { storingCreditTransaction: true } );
		this.transactionRepository.store( creditGroup ).then( ( result: any ) => {
			this.setState( { storingCreditTransaction: false } );
			this.return();
		});
	}
	
	render() {
		return (
			<Page title={'Transaction creator'}>
				<div style={ { marginBottom: '8px' } }>
					<a href='/wp-admin/admin.php?page=tokenly-credit-group-index'>Back to credit group list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<TransactionStoreForm
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
