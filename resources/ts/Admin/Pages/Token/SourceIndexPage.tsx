import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import { SourceItem } from '../../../Interfaces';
import SourceList from '../../Components/Token/SourceList';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import { TYPES } from '../../../Types';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	Spinner,
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
	loadingSources: boolean;
	sources: any;
}

export default class SourceIndexPage extends Component<SourceIndexPageProps, SourceIndexPageState> {
	@resolve( TYPES.Repositories.Token.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;

	state: SourceIndexPageState = {
		sourceData: [],
		sources: {},
		loadingSources: false,
	}
	constructor( props: SourceIndexPageProps ) {
		super( props );
	}

	componentWillMount() {
		this.setState( { loadingSources: true } );
		this.sourceRepository.index( {
			with: [ 'address' ],
		} ).then( ( sources: any ) => {
			this.setState( {
				loadingSources: false,
				sources: sources,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={'Sources'}>
				<div style={{marginBottom: '8px'}}>
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenly-token-vendor'>Back to vendor</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex style={{width: '100%'}}>
								<Button
									isPrimary
									href='/wp-admin/admin.php?page=tokenly-token-source-store'
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
							<Flex>
								{ this.state.loadingSources
								?	<Flex justify="flex-start">
										<span>Loading sources ... </span>
										<Spinner />
									</Flex>
								:	<Flex>
										{ Object.keys( this.state.sources ).length > 0
											? <SourceList
												sources={ this.state.sources }
												loadingSources={ this.state.loadingSources }
											/>
											: <div style={ { opacity: 0.5 } }>There are no registered sources</div>
										}
									</Flex>
								}
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
