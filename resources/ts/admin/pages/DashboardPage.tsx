import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SavePanel } from '../components/SavePanel';

import { 
	Card,
	CardBody,
	CardHeader,
	CardFooter,
	Button,
	Dashicon,
	Icon,
} from '@wordpress/components';

interface DashboardCardItem {
	title: string;
	description: string;
	icon: string;
	url: string;
	admin: boolean;
}

interface DashboardPageData {
	is_admin: boolean;
}

interface DashboardPageProps {
	pageData: DashboardPageData; 
}

interface DashboardPageState {
	cards: Array<DashboardCardItem>,
}

export default class DashboardPage extends Component<DashboardPageProps, DashboardPageState> {
	state: DashboardPageState = {
		cards: [
			{
				title: 'Main Dashboard',
				description: 'Tokenpass main dashboard (external).',
				icon: 'dashboard',
				url: 'https://tokenpass.tokenly.com/dashboard',
				admin: false,
			},
			{
				title: 'Inventory',
				description: 'View the list of currently owned token assets.',
				icon: 'money',
				url: '/tokenpass-user/me',
				admin: false,
			},
			{
				title: 'Connection',
				description: 'Connect or disconnect to Tokenpass network.',
				icon: 'admin-plugins',
				url: '/wp-admin/admin.php?page=tokenpass-connection',
				admin: false,
			},
			{
				title: 'Vendor',
				description: 'Manage token promises.',
				icon: 'share',
				url: '/wp-admin/admin.php?page=tokenpass-vendor',
				admin: true,
			},
			{
				title: 'Whitelist',
				description: 'Configure a filter for tokens displayed on the inventory pages.',
				icon: 'forms',
				url: '/wp-admin/admin.php?page=tokenpass-whitelist',
				admin: true,
			},
			{
				title: 'Token Meta',
				description: 'Manage additional information for tokens, displayed on the Inventory page.',
				icon: 'media-default',
				url: '/wp-admin/edit.php?post_type=token-meta',
				admin: true,
			},
			{
				title: 'Settings',
				description: 'Manage plugin settings.',
				icon: 'admin-settings',
				url: '/wp-admin/admin.php?page=tokenpass-settings',
				admin: true,
			},

		],
	}
	constructor( props: DashboardPageProps ) {
		super( props );
		this.canView = this.canView.bind( this );
	}

	canView( cardItem: any ) {
		if ( this.props.pageData.is_admin === true || cardItem.admin === false ) {
			return true;
		} else {
			false;
		}
	}

	render() {
		const cards = this.state.cards.map( ( cardItem: DashboardCardItem, i: number ) => {
			if ( this.canView( cardItem ) === true ) {
				return (
					<Card>
						<CardHeader style={{display: 'flex', justifyContent: 'flex-start',}}><Dashicon icon={cardItem.icon as any} /><h3>{cardItem.title}</h3></CardHeader>
						<CardBody size="large">{cardItem.description}</CardBody>
						<CardFooter>
							<Button isPrimary href={cardItem.url}>Visit page</Button>
						</CardFooter>
					</Card>
				);
			}
		}

		);
		return (
			<Page title={'Tokenpass Dashboard'}>
				<div className="dashboard-card-grid">
					{cards}
				</div>
			</Page>
		);
	}
}
