import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import PromiseRepositoryInterface from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import { TYPES } from '../../../Types';
import Preloader from '../../Components/Preloader';
import PromiseInfo from '../../Components/Token/PromiseInfo';
import PromiseLink from '../../Components/Token/PromiseLink';

import { 
	Button,
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Flex,
	Spinner,
} from '@wordpress/components';

interface PromiseShowPageData {
	//
}

interface PromiseShowPageProps {
	pageData: PromiseShowPageData;
}

interface PromiseShowPageState {
	id: number;
	promise: any;
	sources: any;
	loadingPromise: boolean;
}

export default class PromiseShowPage extends Component<PromiseShowPageProps, PromiseShowPageState> {
	@resolve( TYPES.Repositories.Token.PromiseRepositoryInterface )
	promiseRepository: PromiseRepositoryInterface;

	state: PromiseShowPageState = {
		id: null,
		promise: null,
		sources: null,
		loadingPromise: false,
	}
	constructor( props: PromiseShowPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = parseInt( urlParams.get( 'promise' ) );
	}

	componentWillMount() {
		this.setState( { loadingPromise: true } );
		const params = {
			with: [
				'source.address',
				'promise_meta.source_user',
				'promise_meta.destination_user',
			],
		}
		this.promiseRepository.show( this.state.id, params ).then( ( promise: any ) => {
			this.setState( {
				loadingPromise: false,
				promise: promise,
			} );
		} );
	}
	
	render() {

		return (
			<Page title={ 'Promise display' }>
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loadingPromise } label="promise" />
					{ !this.state.loadingPromise &&
						<PromiseLink id={ this.state.id } />
					}
					</PanelHeader>
					{ !this.state.loadingPromise &&
					<PanelBody>
						<PanelRow>
							<PromiseInfo promise={this.state.promise} verbose />
						</PanelRow>
					</PanelBody>
					}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex style={{width: '100%'}}>
								<Button
									isSecondary
									isLarge
									href={ `/wp-admin/admin.php?page=tokenly-token-promise-edit&promise=${ this.state.id }` }
								>
									Manage promise
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
