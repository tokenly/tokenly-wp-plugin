import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { PromiseRepository, PromiseData, PromiseStoreData } from '../../repositories/PromiseRepository';
import { PromiseStoreForm } from '../components/PromiseStoreForm';

declare const wp: any;
declare const window: any;

const { __ } = wp.i18n;

const {
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Modal,
} = wp.components;

interface SourceIndexPageData {
	//
}

interface SourceIndexPageProps {
	pageData: SourceIndexPageData;
	saving: boolean;
}

interface User {
	name: string;
	id: number;
}

interface SourceIndexPageState {
	promiseData: Array<PromiseData>;
	isCreatePromiseModalOpen: boolean;
	storingPromise: boolean;
}

export default class SourceIndexPage extends Component<SourceIndexPageProps, SourceIndexPageState> {
	@resolve
	promiseRepository: PromiseRepository;
	
	state: SourceIndexPageState = {
		promiseData: [],
		isCreatePromiseModalOpen: false,
		storingPromise: false,
	}
	constructor( props: SourceIndexPageProps ) {
		super( props );
		this.onPromiseSubmit = this.onPromiseSubmit.bind( this );
	}
	
	componentDidMount() {
		this.promiseRepository.index().then( ( promiseData: Array<PromiseData> ) => {
			this.setState( {
				promiseData: promiseData,
			} );
		} );
	}
	
	onPromiseSubmit( promise: PromiseStoreData ) {
		this.promiseRepository.store( promise ).then( result => {
			window.location = '/wp-admin/admin.php?page=tokenpass-vendor';
		});
	}
	
	render() {
		return (
			<Page title={'Create token promise'}>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Button
								text='Register source address'
								isPrimary
								isLarge
								href='/wp-admin/admin.php?page=tokenpass-source-store'
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
