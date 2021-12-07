import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SourceItem } from '../../Interfaces';
import { CreditTransactionList } from '../Components/CreditTransactionList';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface CreditTransactionIndexPageData {
	credit_transactions: Array<any>;
}

interface CreditTransactionIndexPageProps {
	pageData: CreditTransactionIndexPageData;
}

interface CreditTransactionIndexPageState {
	//
}

export default class CreditTransactionIndexPage extends Component<CreditTransactionIndexPageProps, CreditTransactionIndexPageState> {
	state: CreditTransactionIndexPageState = {
		//
	}
	constructor( props: CreditTransactionIndexPageProps ) {
		super( props );
	}
	
	render() {
		return (
			<Page title={'Credit Transactions'}>
				<div style={ { marginBottom: '8px' } }>
					<a href='/wp-admin/admin.php?page=tokenly-credit-group-index'>Back to credit group list</a>
				</div>
				<Panel header="Transactions">
					<PanelBody>
						<PanelRow>
							<CreditTransactionList creditTransactions={ this.props.pageData.credit_transactions } />
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
