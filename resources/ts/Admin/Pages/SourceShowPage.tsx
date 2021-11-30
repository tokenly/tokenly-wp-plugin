import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SourceItem } from '../../Interfaces';
import { BalanceList } from '../Components/BalanceList';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface SourceShowPageData {
	source: SourceItem;
}

interface SourceShowPageProps {
	pageData: SourceShowPageData;
}

interface SourceShowPageState {
	//
}

export default class SourceShowPage extends Component<SourceShowPageProps, SourceShowPageState> {
	state: SourceShowPageState = {
		//
	}
	constructor( props: SourceShowPageProps ) {
		super( props );
		this.getAssetNames = this.getAssetNames.bind( this );
		console.log(this.props.pageData);
	}

	getAssetNames() {
		let balances = this.props.pageData?.source?.address_data?.balances;
		if ( !balances ) {
			return;
		}
		let assets = [] as any;
		Object.keys( balances ).map( ( key, index ) => {
			assets.push( balances[ key ].asset );
		} );
		assets = assets.join( ', ' );
		return assets;
	}
	
	render() {
		return (
			<Page title={ 'Source details' }>
				<div style={{marginBottom: '8px'}}>
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenly-vendor'>Back to vendor</a>
				</div>
				<Panel header={ this.props.pageData.source.address_data.label }>
					<PanelBody>
						<PanelRow>
							<Flex style={ { width: '100%', alignItems: 'center' } }>
								<div style={ { flex: 1 } }>
									<div><span>Type: </span><strong>{ this.props.pageData.source.type }</strong></div>
									<div><span>Address: </span><strong>{ this.props.pageData.source.address }</strong></div>
									{/* <div><span>Assets: </span><strong>{ this.getAssetNames() ?? 'none' }</strong></div> */}
									<div><span>Assets (whitelisted): </span><strong>{ this.props.pageData.source.assets ?? 'all' }</strong></div>
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
									href={ `/wp-admin/admin.php?page=tokenly-source-edit&source=${ this.props.pageData.source.address }` }
								>
									Manage source
								</Button>
								<Button
									isSecondary
									isLarge
									href={ `/wp-admin/admin.php?page=tokenly-balances-show&address=${ this.props.pageData.source.address }` }
								>
									View balances
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
