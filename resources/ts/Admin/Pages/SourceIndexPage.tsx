import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SourceItem } from '../../Interfaces';
import { SourceList } from '../Components/SourceList';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface SourceIndexPageData {
	sources: Array<SourceItem>;
}

interface SourceIndexPageProps {
	pageData: SourceIndexPageData;
	saving: boolean;
}

interface SourceIndexPageState {
	sourceData: Array<SourceItem>;
	storingPromise: boolean;
}

export default class SourceIndexPage extends Component<SourceIndexPageProps, SourceIndexPageState> {
	state: SourceIndexPageState = {
		sourceData: [],
		storingPromise: false,
	}
	constructor( props: SourceIndexPageProps ) {
		super( props );
		console.log(this.props.pageData.sources);
	}
	
	render() {
		return (
			<Page title={'Sources'}>
				<div style={{marginBottom: '8px'}}>
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenly-vendor'>Back to vendor</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex style={{width: '100%'}}>
								<Button
									isPrimary
									href='/wp-admin/admin.php?page=tokenly-source-store'
								>
									Register source
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel header="Registered sources">
					<PanelBody>
						<PanelRow>
							<SourceList sourceList={ this.props.pageData.sources } />
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
