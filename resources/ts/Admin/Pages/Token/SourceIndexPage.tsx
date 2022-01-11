import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import { TYPES } from '../../../Types';
import { SourceItem } from '../../../Interfaces';
import Page from './../Page';
import SourceList from '../../Components/Token/SourceList';
import Preloader from '../../Components/Preloader';
import { 
	Button,
	Panel,
	PanelHeader,
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
	loadingSources: boolean;
	sources: any;
}

export default class SourceIndexPage extends Component<SourceIndexPageProps, SourceIndexPageState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	@resolve( TYPES.Repositories.Token.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;

	state: SourceIndexPageState = {
		sourceData: [],
		sources: null,
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
			<Page title="Source Listing">
				<Panel header="Source Actions">
					<PanelBody>
						<PanelRow>
							<Flex style={{width: '100%'}}>
								<Button
									isPrimary
									href={ `${this.adminPageUrl}${this.namespace}-token-source-store` }
								>
									Register Source
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelHeader>
						<Preloader loading={this.state.loadingSources}>Registered sources</Preloader>
					</PanelHeader>
				{
				(
					!this.state.loadingSources &&
					this.state.sources &&
					typeof this.state.sources === 'object'
				) &&
					<PanelBody>
						<PanelRow>
							<Flex>
								{ Object.keys( this.state.sources ).length > 0
									? <SourceList
										sources={ this.state.sources }
										loadingSources={ this.state.loadingSources }
									/>
									: <div style={ { opacity: 0.5 } }>There are no registered sources</div>
								}
							</Flex>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
			</Page>
		);
	}
}
