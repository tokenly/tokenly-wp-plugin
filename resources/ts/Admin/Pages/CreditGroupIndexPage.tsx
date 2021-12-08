import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SourceItem } from '../../Interfaces';
import { CreditGroupList } from '../Components/CreditGroupList';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface CreditGroupIndexPageData {
	credit_groups: Array<any>;
}

interface CreditGroupIndexPageProps {
	pageData: CreditGroupIndexPageData;
}

interface CreditGroupIndexPageState {
	//
}

export default class CreditGroupIndexPage extends Component<CreditGroupIndexPageProps, CreditGroupIndexPageState> {
	state: CreditGroupIndexPageState = {
		//
	}
	constructor( props: CreditGroupIndexPageProps ) {
		super( props );
	}
	
	render() {
		return (
			<Page title={'Credit Groups'}>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex
								justify="flex-start"
								style={ { width: '100%' } }
							>
								<Button
									isPrimary
									href='/wp-admin/admin.php?page=tokenly-credit-transaction-store'
								>
									Make transaction
								</Button>
								<Button
									isPrimary
									href='/wp-admin/admin.php?page=tokenly-credit-group-store'
								>
									Register credit group
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel header="Registered credit groups">
					<PanelBody>
						<PanelRow>
							<CreditGroupList creditGroups={ this.props.pageData.credit_groups } />
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
