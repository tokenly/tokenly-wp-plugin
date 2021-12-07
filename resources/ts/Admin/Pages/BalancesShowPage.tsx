import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { BalanceList } from '../Components/BalanceList';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface BalancesShowPageData {
	address: any;
}

interface BalancesShowPageProps {
	pageData: BalancesShowPageData;
}

interface BalancesShowPageState {
	//
}

export default class BalancesShowPage extends Component<BalancesShowPageProps, BalancesShowPageState> {
	state: BalancesShowPageState = {
		//
	}
	constructor( props: BalancesShowPageProps ) {
		super( props );
	}
	
	render() {
		return (
			<Page title={'Address balances'}>
				<div style={{marginBottom: '8px'}}>
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenly-source-index'>To source list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<div style={{width: '100%'}} >
								<div style={{marginBottom: '12px'}}>
									<span>Address: </span>
									<strong>
										{ this.props.pageData?.address?.address }
									</strong>
								</div>
								<BalanceList balance={ this.props.pageData?.address?.balance ?? [] } />
							</div>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
