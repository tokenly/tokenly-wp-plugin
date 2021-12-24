import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import { SourceItem } from '../../../Interfaces';

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
	}

	getAssetNames() {
		let balances = this.props.pageData?.source?.address?.balances;
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
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenly-token-vendor'>Back to vendor</a>
				</div>
				<Panel header={ this.props.pageData.source.address.label }>
					<PanelBody>
						<PanelRow>
							<Flex style={ { width: '100%', alignItems: 'center' } }>
								<div style={ { flex: 1 } }>
									<div><span>Type: </span><strong>{ this.props.pageData.source.type }</strong></div>
									<div><span>Address: </span><strong>{ this.props.pageData.source.address_id }</strong></div>
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
									href={ `/wp-admin/admin.php?page=tokenly-token-source-edit&source=${ this.props.pageData.source.address_id }` }
								>
									Manage source
								</Button>
								<Button
									isSecondary
									isLarge
									href={ `/wp-admin/admin.php?page=tokenly-token-balance-index&address=${ this.props.pageData.source.address_id }` }
								>
									View balance
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
