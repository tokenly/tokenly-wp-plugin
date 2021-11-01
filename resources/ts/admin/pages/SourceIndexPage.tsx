import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SourceItem } from '../../interfaces';
import { SourceList } from '../components/SourceList';

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
	isCreatePromiseModalOpen: boolean;
	storingPromise: boolean;
}

export default class SourceIndexPage extends Component<SourceIndexPageProps, SourceIndexPageState> {
	state: SourceIndexPageState = {
		sourceData: [],
		isCreatePromiseModalOpen: false,
		storingPromise: false,
	}
	constructor( props: SourceIndexPageProps ) {
		super( props );
	}
	
	render() {
		return (
			<Page title={'Source addresses'}>
				<div style={{marginBottom: '8px'}}>
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenpass-vendor'>Back to vendor</a>
				</div>
				<Panel header="Source actions">
					<PanelBody>
						<PanelRow>
							<Flex style={{width: '100%'}}>
								<Button
									isPrimary
									isLarge
									href='/wp-admin/admin.php?page=tokenpass-source-store'
								>
									Register address
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel header="Registered addresses">
					<PanelBody>
						<PanelRow>
							<SourceList sourceList={this.props.pageData.sources} />
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
