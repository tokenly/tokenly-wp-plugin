import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import { SourceItem } from '../../../Interfaces';
import { BalanceList } from '../../Components/BalanceList';
import * as dayjs from 'dayjs'

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface GroupShowPageData {
	credit_group: any;
}

interface GroupShowPageProps {
	pageData: GroupShowPageData;
}

interface GroupShowPageState {
	//
}

export default class GroupShowPage extends Component<GroupShowPageProps, GroupShowPageState> {
	state: GroupShowPageState = {
		//
	}
	constructor( props: GroupShowPageProps ) {
		super( props );
	}

	dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}

	render() {
		return (
			<Page title={ 'Credit group details' }>
				<div style={{marginBottom: '8px'}}>
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenly-credit-group-index'>Back to credit group list</a>
				</div>
				<Panel header={ this.props.pageData.credit_group.name }>
					<PanelBody>
						<PanelRow>
							<Flex style={ { width: '100%', alignItems: 'center' } }>
								<div style={ { flex: 1 } }>
									<div><span>Name: </span><strong>{ this.props.pageData.credit_group.name }</strong></div>
									<div><span>UUID: </span><strong>{ this.props.pageData.credit_group.uuid }</strong></div>
									<div><span>Active: </span><span><strong>{this.props.pageData.credit_group.active ? 'Yes' : 'No' }</strong></span></div>
									<div><span>App whitelist: </span><span><strong>{this.props.pageData.credit_group.app_whitelist}</strong></span></div>
									<div><span>Created at: </span><span><strong>{this.dateFormatted( this.props.pageData.credit_group.created_at ) }</strong></span></div>
									<div><span>Updated at: </span><span><strong>{this.dateFormatted( this.props.pageData.credit_group.updated_at ) }</strong></span></div>
								</div>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex justify="flex-start" style={{width: '100%'}}>
								<Button
									isSecondary
									isLarge
									href={ `/wp-admin/admin.php?page=tokenly-credit-group-edit&credit_group=${ this.props.pageData.credit_group.uuid }` }
								>
									Manage credit group
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
