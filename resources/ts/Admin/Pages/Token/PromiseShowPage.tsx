import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import PromiseRepositoryInterface from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import { TYPES } from '../../../Types';
import Preloader from '../../Components/Preloader';
import PromiseInfo from '../../Components/Token/PromiseInfo';
import PromiseLink from '../../Components/Token/PromiseLink'
import { 
	Button,
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Flex,
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
	loadingPromise: boolean;
	loadingAddress: boolean;
}

export default class PromiseShowPage extends Component<PromiseShowPageProps, PromiseShowPageState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	@resolve( TYPES.Repositories.Token.PromiseRepositoryInterface )
	promiseRepository: PromiseRepositoryInterface;
	@resolve( TYPES.Repositories.Token.AddressRepositoryInterface )
	addressRepository: AddressRepositoryInterface;

	state: PromiseShowPageState = {
		id: null,
		promise: null,
		loadingPromise: false,
		loadingAddress: false,
	}
	constructor( props: PromiseShowPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = parseInt( urlParams.get( 'promise' ) );
	}

	componentWillMount() {
		this.setState( {
			loadingPromise: true,
			loadingAddress: true,
		} );
		const params = {
			with: [
				'promise_meta.source_user',
				'promise_meta.destination_user',
			],
		}
		this.promiseRepository.show( this.state.id, params ).then( ( promise: any ) => {
			this.setState( {
				loadingPromise: false,
				promise: promise,
			} );
			return promise;
		} ).then( ( promise: any ) => {
			this.addressRepository.show( promise.source_id ).then( ( address: any ) => {
				promise.source = {};
				promise.source.address = address;
				this.setState( {
					loadingAddress: false,
					promise: promise,
				} );
			} );
		} );
	}
	
	render() {

		return (
			<Page title="Promise Display">
				<Panel>
					<PanelHeader>
						<Preloader loading={ ( this.state.loadingPromise || this.state.loadingAddress ) }>
							Promise Info
						</Preloader>
					</PanelHeader>
					{ ( !this.state.loadingPromise && this.state.promise ) &&
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
							<Flex>
								<Button
									isSecondary
									isLarge
									href={ `${this.adminPageUrl}${this.namespace}-token-promise-edit&promise=${ this.state.id }` }
								>
									Manage Promise
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
